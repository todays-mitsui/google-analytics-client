<?php

namespace Segment\SegmentCondition;

class Condition
{
    /**
     * Metrics scope.
     */
    const PerUser    = "perUser::";
    const PerSession = "perSession::";
    const PerHit     = "perHit::";

    /**
     * Dimension or metric Operators.
     */
    const EQ     = "==";  // 等しいまたは完全一致
    const NEQ    = "!=";  // 等しくない、または完全一致でない
    const LT     = "<";   // 小さい
    const LTE    = "<=";  // 以下
    const GT     = ">";   // 大きい
    const GTE    = ">=";  // 以上
    const IN     = "<>";  // 範囲（指定された範囲内の値）
    const ANY    = "[]";  // リスト内（リストされた値のいずれか）
    const NANY   = "![]"; // リスト外（リストされた値のいずれでもない）
    const LIKE   = "=@";  // 文字列の一部に一致
    const NLIKE  = "!@";  // 文字列の一部に一致しない
    const MATCH  = "=~";  // 正規表現の一致を含む
    const NMATCH = "!~";  // 正規表現の一致を含まない

    /**
     * Logical operators.
     */
    const _AND = ";";
    const _OR  = ",";

    private $conditions = [];

    private function __construct($metric_scope, $metrics, $operator, $condition)
    {
        $this->conditions[] = [null, $metric_scope, $metrics, $operator, $condition];
    }


    public function __toString()
    {
        $conditions = $this->conditions;

        return join("", array_map(function($condition) {
            return join("", $condition);
        }, $conditions));
    }


    public static function eq($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::EQ, $condition);
    }

    public static function not_eq($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::NEQ, $condition);
    }

    public static function lt($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::LT, $condition);
    }

    public static function lte($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::LTE, $condition);
    }

    public static function gt($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::GT, $condition);
    }

    public static function gte($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::GTE, $condition);
    }

    public static function in($metrics, array $range, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::IN, $range[0]."_".$range[1]);
    }

    public static function any($metrics, array $conditions, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::ANY, join("|", $conditions));
    }

    public static function not_any($metrics, array $conditions, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::NANY, join("|", $conditions));
    }

    public static function like($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::LIKE, $condition);
    }

    public static function not_like($metrics, $condition, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::NLIKE, $condition);
    }

    public static function match($metrics, $regexp, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::MATCH, $regexp);
    }

    public static function not_match($metrics, $regexp, $metric_scope = null)
    {
        return new Condition($metric_scope, $metrics, self::NMATCH, $regexp);
    }


    public function and_eq($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::EQ, $condition];

        return $this;
    }

    public function and_not_eq($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::NEQ, $condition];

        return $this;
    }

    public function and_lt($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::LT, $condition];

        return $this;
    }

    public function and_lte($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::LTE, $condition];

        return $this;
    }

    public function and_gt($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::GT, $condition];

        return $this;
    }

    public function and_gte($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::GTE, $condition];

        return $this;
    }

    public function and_in($metrics, array $range, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::IN, $range[0]."_".$range[1]];

        return $this;
    }

    public function and_any($metrics, array $conditions, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::ANY, join("|", $conditions)];

        return $this;
    }

    public function and_not_any($metrics, array $conditions, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::NANY, join("|", $conditions)];

        return $this;
    }

    public function and_like($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::LIKE, $condition];

        return $this;
    }

    public function and_not_like($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::NLIKE, $condition];

        return $this;
    }

    public function and_match($metrics, $regexp, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::MATCH, $regexp];

        return $this;
    }

    public function and_not_match($metrics, $regexp, $metric_scope = null)
    {
        $this->conditions[] = [self::_AND, $metric_scope, $metrics, self::NMATCH, $regexp];

        return $this;
    }


    public function or_eq($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::EQ, $condition];

        return $this;
    }

    public function or_not_eq($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::NEQ, $condition];

        return $this;
    }

    public function or_lt($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::LT, $condition];

        return $this;
    }

    public function or_lte($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::LTE, $condition];

        return $this;
    }

    public function or_gt($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::GT, $condition];

        return $this;
    }

    public function or_gte($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::GTE, $condition];

        return $this;
    }

    public function or_in($metrics, array $range, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::IN, $range[0]."_".$range[1]];

        return $this;
    }

    public function or_any($metrics, array $conditions, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::ANY, join("|", $conditions)];

        return $this;
    }

    public function or_not_any($metrics, array $conditions, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::NANY, join("|", $conditions)];

        return $this;
    }

    public function or_like($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::LIKE, $condition];

        return $this;
    }

    public function or_not_like($metrics, $condition, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::NLIKE, $condition];

        return $this;
    }

    public function or_match($metrics, $regexp, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::MATCH, $regexp];

        return $this;
    }

    public function or_not_match($metrics, $regexp, $metric_scope = null)
    {
        $this->conditions[] = [self::_OR, $metric_scope, $metrics, self::NMATCH, $regexp];

        return $this;
    }
}
