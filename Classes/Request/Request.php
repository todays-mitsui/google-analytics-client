<?php

namespace Request;

class Request
{
    protected $metrics = [];

    protected $dimensions = [];

    protected $filters = [];

    protected $segment = [];

    public function __construct() {
        $this->metrics    = $this->metrics();
        $this->dimensions = $this->dimensions();
        $this->filters    = $this->filters();
        $this->segment    = $this->segment();
    }

    protected function dimensions()
    {
        return [];
    }

    protected function filters()
    {
        return [];
    }

    protected function segment()
    {
        return [];
    }
}
