<?php

namespace Segment\Condition;

use Segment\Condition\Type;

class Scope
{
    /**
     * 条件のスコープ(ユーザー または セッション)
     */
    const Users    = "users";
    const Sessions = "sessions";

    /**
     * 条件結合子
     */
    const _AND = ";";
    const _OR  = ",";


    /**
     * 条件のスコープ(ユーザー または セッション)
     *
     * @var string
     */
    protected $scope = null;

    /**
     * 条件
     *
     * @var array(Type)
     */
    protected $types = [
        "condition" => null,
        "sequence" => null,
    ];


    /**
     * @param string $scope 条件のスコープ(ユーザー または セッション)
     * @param Type   $type  条件
     */
    private function __construct($scope, array $types)
    {
        $this->scope = $scope;

        $this->types = self::init(is_array($types) ? $types : [$types]);
    }

    public function __toString() {
        return $this->scope . "::" . join(";", array_filter($this->types));
    }


    /**
     * $types を condition:: と sequence:: とでふるい分けしてそれぞれ merge する
     *
     * @param array(Type) $types 条件の配列
     * @param array(Type)
     */
    public static function init(array $types)
    {
        $conditions = [];
        $sequences = [];

        foreach ($types as $type) {
            if ("condition" === $type->get_type()) {
                $conditions[] = $type;
            } else if ("sequence" === $type->get_type()) {
                $sequences[] = $type;
            }
        }

        return [
            "condition" => Type::merge($conditions),
            "sequence" => Type::merge($sequences),
        ];
    }

    /**
     * 新しいユーザースコープ条件を作る
     *
     * @param  array(Type) $types 条件
     * @return Scope
     */
    public static function users(array $types) {
        return new self(
            self::Users,
            $types
        );
    }

    /**
     * 新しいセッションスコープ条件を作る
     *
     * @param  array(Type) $types 条件
     * @return Scope
     */
    public static function sessions(array $types) {
        return new self(
            self::Sessions,
            $types
        );
    }


    /**
     * 条件のスコープ(ユーザー または セッション)を返す
     *
     * @return string
     */
    public function get_scope()
    {
        return $this->scope;
    }

    /**
     * 条件 または シーケンス の配列を返す
     *
     * @return array
     */
    public function get_types()
    {
        return $this->types;
    }


    /**
     * 複数の条件をマージする
     *
     * @param  array(Scope) $scopes マージする Scope の配列
     * @return Scope
     */
    public static function merge(array $scopes)
    {
        if (empty($scopes)) { return null; }

        $types = [];
        foreach ($scopes as $scope) {
            $types = array_merge(
                $types,
                array_merge($scope->get_types())
            );
        }

        $types = array_filter($types);

        return new self(
            $scopes[0]->get_scope(),
            $types
        );
    }
}
