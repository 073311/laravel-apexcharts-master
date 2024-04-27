<?php

namespace ievtds\Apexcharts\Traits;

use ievtds\Apexcharts\Types\Area;
use ievtds\Apexcharts\Types\Bar;
use ievtds\Apexcharts\Types\Donut;
use ievtds\Apexcharts\Types\HeatMap;
use ievtds\Apexcharts\Types\HorizontalBar;
use ievtds\Apexcharts\Types\Line;
use ievtds\Apexcharts\Types\Pie;
use ievtds\Apexcharts\Types\PolarArea;
use ievtds\Apexcharts\Types\Radar;
use ievtds\Apexcharts\Types\Radial;

trait Types
{
    public function area(): Area
    {
        return new Area();
    }

    public function bar(): Bar
    {
        return new Bar();
    }

    public function donut(): Donut
    {
        return new Donut();
    }

    public function heatMap(): HeatMap
    {
        return new HeatMap();
    }

    public function horizontalBar(): HorizontalBar
    {
        return new HorizontalBar();
    }

    public function line(): Line
    {
        return new Line();
    }

    public function pie(): Pie
    {
        return new Pie();
    }

    public function polarArea(): PolarArea
    {
        return new PolarArea();
    }

    public function radar(): Radar
    {
        return new Radar();
    }

    public function radial(): Radial
    {
        return new Radial();
    }
}
