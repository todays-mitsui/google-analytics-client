<?php

namespace Query;

use Metrics\Metrics;

class Basic
{
    public funciton metrics()
    {
        return [
            Metrics::Sessions,
            Metrics::Users,
            Metrics::BounceRate,
            Metrics::AvgSessionDuration,
            Metrics::PageviewsParSession,
        ];
    }
}
