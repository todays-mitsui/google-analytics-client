<?php

namespace Segment\SegmentCondition;

use Segment\SegmentCondition\Scope;

class SegmentCondition
{
    /**
     * Logical operators.
     */
    const _AND = ";";
    const _OR  = ",";

    protected $scopes = [];

    public function __construct(Scope $scope)
    {
        $this->scopes[] = [null, $scope];
    }

    public function __toString() {
        $scopes = $this->scopes;

        return join("", array_map(function($scope) {
            return join("", $scope);
        }, $scopes));
    }


    public static function create(Scope $scope)
    {
        return new SegmentCondition($scope);
    }


    public function _and(Scope $scope)
    {
        $this->scopes[] = [self::_AND, $scope];

        return $this;
    }

    public function _or(Scope $scope)
    {
        $this->scopes[] = [self::_OR, $scope];

        return $this;
    }

    public function __call($method, $args)
    {
        if($method === 'and') {
            return call_user_func_array(array($this, '_and'), $args);
        } else if($method === 'or') {
            return call_user_func_array(array($this, '_or'), $args);
        } else {
            throw new LogicException('Unknown method');
        }
    }
}
