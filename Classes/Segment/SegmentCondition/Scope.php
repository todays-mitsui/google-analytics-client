<?php

namespace Segment\SegmentCondition;

use Segment\SegmentCondition\Type;

class Scope
{
    /**
     * Condition scope.
     */
    const Users    = "users";
    const Sessions = "sessions";

    /**
     * Logical operators.
     */
    const _AND = ";";
    const _OR  = ",";

    protected $scope = null;

    protected $types = [];

    private function __construct($scope, Type $type)
    {
        $this->scope   = $scope;
        $this->types[] = [null, $type];
    }

    public function __toString() {
        $types = $this->types;

        return $this->scope . "::" . join("", array_map(function($type) {
            return join("", $type);
        }, $types));
    }


    public static function users(Type $type) {
        return new Scope(self::Users, $type);
    }

    public static function sessions(Type $type) {
        return new Scope(self::Sessions, $type);
    }


    public function _and(Type $type) {
        $this->types[] = [self::_AND, $type];

        return $this;
    }

    public function _or(Type $type) {
        $this->types[] = [self::_OR, $type];

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
