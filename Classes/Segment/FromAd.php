<?php

namespace Segment;

use Metrics\Metrics;
use Dimensions\Dimensions;

use Segment\Segment;

use Segment\Condition\Scope;
use Segment\Condition\Type;
use Segment\Condition\SegmentCondition;

class FromAd extends Segment
{
    public function segment() {
        return [
            Scope::users([
                Type::condition(Condition::match(Dimensions::Medium, "^(cpc|ppc|cpa|cpm|cpv|cpp)$")),
                Type::sequence(Condition::eq())
                    ->and(Condition::eq())
                    ->or(Condition::eq()),
            ]),
            Scope::sessions([
                Type::condition(),
                Type::sequence(),
            ]),
        ];

        return Scope::sessions(
            Type::condition(
                SegmentCondition::not_eq(Dimensions::Lang, "(not set)")
            )->and(
                SegmentCondition::like(Dimensions::Country, "Japan")
            )->and(
                SegmentCondition::not_eq(Dimensions::Browser, "(not set)")
            )->and(
                SegmentCondition::match(Dimensions::Medium, "^(cpc|ppc|cpa|cpm|cpv|cpp)$")
            )
        );
    }
}
