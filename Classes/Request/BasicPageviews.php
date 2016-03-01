<?php

namespace Request;

use Metrics\Metrics;

class BasicPageviews extends Request
{
    public function metrics()
    {
        return [
            Metrics::Sessions,
            Metrics::Users,
            MEtrics::Pageviews,
        ];
    }
}
