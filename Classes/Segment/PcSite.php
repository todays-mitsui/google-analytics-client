<?php

namespace Segment;

use Metrics\Metrics;
use Dimensions\Dimensions;

use Segment\Segment;

use Segment\Condition\Scope;
use Segment\Condition\Type;
use Segment\Condition\SegmentCondition;

class PcSite extends Segment
{
    public function segment() {
        return Scope::sessions(
            Type::Condition(
                SegmentCondition::not_eq(Dimensions::Lang, "(not set)")
            )->and(
                SegmentCondition::like(Dimensions::Country, "Japan")
            )->and(
                SegmentCondition::not_eq(Dimensions::Browser, "(not set)")
            )->and(
                SegmentCondition::match(Dimensions::PagePath, "^/sp/")->not_contain()
            )->and(
                SegmentCondition::match(Dimensions::PagePath, "/(lp|campaign|lgbt)")->not_contain()
            )
        );
    }
}
