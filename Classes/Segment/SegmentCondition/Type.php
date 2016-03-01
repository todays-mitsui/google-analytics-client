<?php

namespace Segment\SegmentCondition;

use Segment\SegmentCondition\Condition;

class Type
{
    /**
     * Condition type.
     */
    const Condition = "condition";
    const Sequence  = "sequence";

    /**
     * Logical operators.
     */
    const _AND = ";";
    const _OR  = ",";

    const FollowedBy            = ";–>>";
    const ImmediatelyFollowedBy = ";–>";

    private $type = null;

    private $conditions = [];


    public function __construct($type, Condition $condition)
    {
        $this->type         = $type;
        $this->conditions[] = [null, $condition];
    }

    public function __toString() {
        $conditions = $this->conditions;

        return $this->type . "::" . join("", array_map(function($condition) {
            return join("", $condition);
        }, $conditions));
    }


    public static function condition(Condition $condition)
    {
        return new Type(self::Condition, $condition);
    }

    public static function sequence(Condition $condition)
    {
        return new Type(self::Sequence, $condition);
    }


    public function _and(Condition $condition)
    {
        $this->conditions[] = [self::_AND, $condition];

        return $this;
    }

    public function _or(Condition $condition)
    {
        $this->conditions[] = [self::_OR, $condition];

        return $this;
    }


    public function followed_by()
    {
        if ($this->type !== self::Sequence) {
            throw new Exception("';->>' 演算子は ConditionType が Sequence のときにしか使用できません。");
        }

        $this->conditions[] = [self::FollowedBy, $condition];

        return $this;
    }

    public function immediately_followed_by()
    {
        if ($this->type !== self::Sequence) {
            throw new Exception("';->' 演算子は ConditionType が Sequence のときにしか使用できません。");
        }

        $this->conditions[] = [self::ImmediatelyFollowedBy, $condition];

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
