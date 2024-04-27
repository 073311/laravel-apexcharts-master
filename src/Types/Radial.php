<?php

namespace ievtds\Apexcharts\Types;

use ievtds\Apexcharts\Chart;

class Radial extends Chart
{
    public function __construct()
    {
        parent::__construct();

        $this->setType('radialBar');
    }

    public function addRings(array $data): Radial
    {
        return $this->setSeries($data);
    }
}
