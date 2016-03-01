<?php

namespace Filters;

use Metrics\Metrics;

class Filters
{
    const EQ  = "==";
    const NEQ = "!=";

    // MetricsFilters
    const GT  = ">";
    const LT  = "<";
    const GTE = ">=";
    const LTE = "<=";

    // DimensionFilters
    const LIKE   = "=@";
    const NLIKE  = "!@";
    const MATCH  = "=~";
    const NMATCH = "!~";

    protected $filters;

    public function __construct()
    {
        $this->filters = $this->filters();
    }

    public function __toString()
    {
        $filters = $this->filters;

        return join(";", array_map(function($inner_filters) {
            return join(",", array_map(function($filter) {
                return join("", $filter);
            }, $inner_filters));
        }, $filters));
    }
}
