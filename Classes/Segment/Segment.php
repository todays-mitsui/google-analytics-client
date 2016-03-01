<?php

namespace Segment;

class Segment
{
    protected $segment = null;

    public function __construct()
    {
        $this->segment = $this->segment();
    }

    public function __toString()
    {
        return (string)$this->segment;
    }
}
