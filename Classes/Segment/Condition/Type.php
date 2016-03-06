<?php

namespace Segment\Condition;

use Segment\Condition\Condition;

class Type
{
    /**
     * 条件の種類(条件 または シーケンス)
     */
    const Condition = "condition";
    const Sequence  = "sequence";

    /**
     * 条件結合子
     */
    const _AND = ";";
    const _OR  = ",";

    /**
     * シーケンス結合子
     */
    const FollowedBy            = ";–>>";
    const ImmediatelyFollowedBy = ";–>";


    /**
     * 条件の種類(条件 または シーケンス)
     *
     * @var string
     */
    private $type = null;

    /**
     * 条件 または シーケンス
     *
     * @var array(Condition)
     */
    private $conditions = [];


    /**
     * @param string    $type      条件の種類(条件 または シーケンス)
     * @param Condition $condition 条件
     */
    private function __construct($type, array $conditions)
    {
        $this->type = $type;
        $this->conditions = $conditions;
    }

    public function __toString() {
        $conditions = $this->conditions;

        return $this->type . "::" . join("", array_map(function($condition) {
            return join("", $condition);
        }, $conditions));
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

    /**
     * 新しい条件を作る
     *
     * @param  Condition $condition 条件
     * @return Type
     */
    public static function condition(Condition $condition)
    {
        return new self(
            self::Condition,
            [[null, $condition]]
        );
    }

    /**
     * 新しいシーケンス条件を作る
     *
     * @param  Condition $condition 条件
     * @return Type
     */
    public static function sequence(Condition $condition)
    {
        return new self(
            self::Sequence,
            [[null, $condition]]
        );
    }


    /**
     * AND で結合して条件を追加する
     *
     * @param  Condition $condition
     * @return Type
     */
    private function _and(Condition $condition)
    {
        $this->conditions[] = [self::_AND, $condition];

        return $this;
    }

    /**
     * OR で結合して条件を追加する
     *
     * @param  Condition $condition
     * @return Type
     */
    private function _or(Condition $condition)
    {
        $this->conditions[] = [self::_OR, $condition];

        return $this;
    }


    /**
     * FollowedBy で結合して条件を追加する
     *
     * @param  Condition $condition
     * @return Type
     */
    public function followed_by(Condition $condition)
    {
        if ($this->type !== self::Sequence) {
            throw new Exception("';->>' 演算子は ConditionType が Sequence のときにしか使用できません。");
        }

        $this->conditions[] = [self::FollowedBy, $condition];

        return $this;
    }

    /**
     * ImmediatelyFollowedBy で結合して条件を追加する
     *
     * @param  Condition $condition
     * @return Type
     */
    public function immediately_followed_by(Condition $condition)
    {
        if ($this->type !== self::Sequence) {
            throw new Exception("';->' 演算子は ConditionType が Sequence のときにしか使用できません。");
        }

        $this->conditions[] = [self::ImmediatelyFollowedBy, $condition];

        return $this;
    }


    /**
     * 条件の種類(条件 または シーケンス)を返す
     *
     * @return string
     */
    public function get_type()
    {
        return $this->type;
    }

    /**
     * 条件 または シーケンス の配列を返す
     *
     * @return array
     */
    public function get_conditions()
    {
        return $this->conditions;
    }


    /**
     * 複数の条件をマージする
     *
     * @param  array(Type) $types マージする Type の配列
     * @return Type
     */
    public static function merge(array $types)
    {
        if (empty($types)) { return null; }

        $head = array_shift($types);
        $tail = $types;

        $conditions = $head->get_conditions();
        foreach ($tail as $type) {
            $new_conditions = $type->get_conditions();
            $new_conditions[0][0] = self::_AND;

            $conditions = array_merge($conditions, $new_conditions);
        }

        return new self(
            $head->get_type(),
            $conditions
        );
    }
}
