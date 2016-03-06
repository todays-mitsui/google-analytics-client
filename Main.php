<?php

require_once("vendor/autoload.php");

use Metrics\Metrics;
use Dimensions\Dimensions;

use Segment\Segment;
use Segment\Condition\Scope;
use Segment\Condition\Type;
use Segment\Condition\Condition;
/*
$from_ad = Scope::sessions([
  Type::condition(Condition::match(Dimensions::Medium, "^(cpc|ppc|cpa|cpm|cpv|cpp)$"))
]);

$pc_site = Scope::users([
    Type::condition(Condition::not_eq(Dimensions::Lang, "(not set)"))
        ->and(Condition::like(Dimensions::Country, "Japan"))
        ->and(Condition::not_eq(Dimensions::Browser, "(not set)"))
        ->and(Condition::match(Dimensions::PagePath, "^/sp/")->not_contain())
        ->and(Condition::match(Dimensions::PagePath, "/(lp|campaign|lgbt)")->not_contain())
]);
*/
class Test extends Segment
{
    public function segment()
    {
        // return Scope::sessions([
        //     Type::condition(Condition::match(Dimensions::Medium, "^(cpc|ppc|cpa|cpm|cpv|cpp)$"))
        // ]);
        return [
            Scope::sessions([
                Type::condition(Condition::match(Dimensions::Medium, "^(cpc|ppc|cpa|cpm|cpv|cpp)$"))
            ]),
            Scope::users([
                Type::condition(Condition::not_eq(Dimensions::Lang, "(not set)"))
                    ->and(Condition::like(Dimensions::Country, "Japan"))
                    ->and(Condition::not_eq(Dimensions::Browser, "(not set)"))
                    ->and(Condition::match(Dimensions::PagePath, "^/sp/")->not_contain())
                    ->and(Condition::match(Dimensions::PagePath, "/(lp|campaign|lgbt)")->not_contain())
            ]),
        ];
    }
}

echo (new Test);
