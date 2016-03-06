<?php

namespace Segment;

use Segment\Condition\Scope;

class Segment
{
    /**
     * 条件
     *
     * @var array(Scope)
     */
    protected $scopes = [
        "users" => null,
        "sessions" => null,
    ];

    public function __construct($scopes = null)
    {
        $scopes = is_null($scopes) ? $this->segment() : $scopes;

        $this->scopes = self::init(is_array($scopes) ? $scopes : [$scopes]);
    }

    public function __toString()
    {
        return join(";", array_filter($this->scopes));
    }


    /**
     * $scopes を users:: と sessions:: とでふるい分けしてそれぞれ merge する
     *
     * @param array(Scope) $scopes 条件の配列
     * @param array(Scope)
     */
    public static function init(array $scopes)
    {
        $users = [];
        $sessions = [];

        foreach ($scopes as $scope) {
            if ("users" === $scope->get_scope()) {
                $users[] = $scope;
            } else if ("sessions" === $scope->get_scope()) {
                $sessions[] = $scope;
            }
        }

        return [
            "users" => Scope::merge($users),
            "sessions" => Scope::merge($sessions),
        ];
    }


    /**
     * 条件スコープの配列を返す
     *
     * @return array
     */
    public function get_scopes()
    {
        return $this->scopes;
    }


    /**
     * 複数のセグメントをマージする
     *
     * @param  array(Segment) $segments マージする Segment の配列
     * @return Segment
     */
    public static function merge(array $segments)
    {
        if (empty($segments)) { return null; }

        $scopes = [];
        foreach ($segments as $segment) {
            $scopes = array_merge(
                $scopes,
                array_merge($segment->get_scopes())
            );
        }

        $scopes = array_filter($scopes);

        return new self($scopes);
    }
}
