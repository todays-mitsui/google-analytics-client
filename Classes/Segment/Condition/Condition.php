<?php

namespace Segment\Condition;

class Condition
{
    /**
     * 指標スコープ
     */
    const PerUser    = "perUser::";    // ユーザーレベル
    const PerSession = "perSession::"; // セッションレベル
    const PerHit     = "perHit::";     // ヒットレベル

    /**
     * 条件判定の演算子
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
     * 指標スコープ
     *
     * @var string
     */
    private $scope = null;

    /**
     * 一致したデータを含める？
     *
     * @var boolean
     */
    private $contain = true;

    /**
     * 条件判定の演算子
     *
     * @var string
     */
    private $operator = "";

    /**
     * 指標(条件式の左辺)
     *
     * @var string
     */
    private $condition_index = "";

    /**
     * 値(条件式の右辺)
     *
     * @var string
     */
    private $condition_value = "";


    /**
     * @param string $operator        条件判定の演算子
     * @param string $condition_index 指標
     * @param string $condition_value 値
     */
    private function __construct($operator, $condition_index, $condition_value)
    {
        $this->operator = $operator;
        $this->condition_index = $condition_index;
        $this->condition_value = $condition_value;
    }

    public function __toString()
    {
        return $this->scope
            . ($this->contain ? "" : "!")
            . $this->condition_index
            . $this->operator
            . $this->condition_value;
    }


    /**
     * 条件:等しいまたは完全一致
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function eq($condition_index, $condition_value)
    {
        return new self(
            self::EQ,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:等しくない、または完全一致でない
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function not_eq($condition_index, $condition_value)
    {
        return new self(
            self::NEQ,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:小さい
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function lt($condition_index, $condition_value)
    {
        return new self(
            self::LT,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:以下
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function lte($condition_index, $condition_value)
    {
        return new self(
            self::LTE,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:大きい
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function gt($condition_index, $condition_value)
    {
        return new self(
            self::GT,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:以上
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function gte($condition_index, $condition_value)
    {
        return new self(
            self::GTE,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:範囲（指定された範囲内の値）
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function in($condition_index, array $condition_value)
    {
        return new self(
            self::IN,
            $condition_index,
            $condition_value[0]."_".$condition_value[1]
      );
    }

    /**
     * 条件:リスト内（リストされた値のいずれか）
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function any($condition_index, array $condition_value)
    {
        return new self(
            self::ANY,
            $condition_index,
            join("|", $condition_value)
      );
    }

    /**
     * 条件:リスト外（リストされた値のいずれでもない）
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function not_any($condition_index, array $condition_value)
    {
        return new self(
            self::NANY,
            $condition_index,
            join("|", $condition_value)
      );
    }

    /**
     * 条件:文字列の一部に一致
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function like($condition_index, $condition_value)
    {
        return new self(
            self::LIKE,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:文字列の一部に一致しない
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function not_like($condition_index, $condition_value)
    {
        return new self(
            self::NLIKE,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:正規表現の一致を含む
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function match($condition_index, $condition_value)
    {
        return new self(
            self::MATCH,
            $condition_index,
            $condition_value
      );
    }

    /**
     * 条件:正規表現の一致を含まない
     *
     * @param  string    $condition_index 指標
     * @param  string    $condition_value 値
     * @return Condition
     */
    public static function not_match($condition_index, $condition_value)
    {
        return new self(
            self::NMATCH,
            $condition_index,
            $condition_value
      );
    }


    /**
     * 指標スコープをユーザーレベルに設定
     *
     * @return Condition
     */
    public function perUser()
    {
        $this->scope = self::PerUser;

        return $this;
    }

    /**
     * 指標スコープをセッションレベルに設定
     *
     * @return Condition
     */
    public function perSession()
    {
        $this->scope = self::PerSession;

        return $this;
    }

    /**
     * 指標スコープをヒットレベルに設定
     *
     * @return Condition
     */
    public function perHit()
    {
        $this->scope = self::PerHit;

        return $this;
    }


    /**
     * 条件に一致したデータを含める
     *
     * @return Condition
     */
    public function contain()
    {
        $this->contain = true;

        return $this;
    }

    /**
     * 条件に一致したデータを除外する
     *
     * @return Condition
     */
    public function not_contain()
    {
        $this->contain = false;

        return $this;
    }
}
