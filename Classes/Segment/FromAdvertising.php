<?php

namespace Segment;

use Metrics\Metrics;
use Dimensions\Dimensions;

use Segment\Segment;

use Segment\SegmentCondition\SegmentCondition;
use Segment\SegmentCondition\Scope;
use Segment\SegmentCondition\Type;
use Segment\SegmentCondition\Condition;

class FromAdvertising extends Segment
{
    public function segment() {
        return SegmentCondition::create(
            Scope::sessions(
                Type::condition(Condition::not_eq(Dimensions::Lang, "(not set)"))
            )->and(
                Type::condition(Condition::like(Dimensions::Country, "Japan"))
            )->and(
                Type::condition(Condition::not_eq(Dimensions::Browser, "(not set)"))
            )->and(
                Type::condition(Condition::match(Dimensions::Medium, "^(cpc|ppc|cpa|cpm|cpv|cpp)$"))
            )
        );
    }
}
