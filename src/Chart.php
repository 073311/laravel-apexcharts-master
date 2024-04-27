<?php

namespace ievtds\Apexcharts;

use ievtds\Apexcharts\Options\Annotations;
use ievtds\Apexcharts\Options\Chart as ChartOption;
use ievtds\Apexcharts\Options\DataLabels;
use ievtds\Apexcharts\Options\Fill;
use ievtds\Apexcharts\Options\ForecastDataPoints;
use ievtds\Apexcharts\Options\Grid;
use ievtds\Apexcharts\Options\Legend;
use ievtds\Apexcharts\Options\Markers;
use ievtds\Apexcharts\Options\NoData;
use ievtds\Apexcharts\Options\PlotOptions;
use ievtds\Apexcharts\Options\Responsive;
use ievtds\Apexcharts\Options\States;
use ievtds\Apexcharts\Options\Stroke;
use ievtds\Apexcharts\Options\Subtitle;
use ievtds\Apexcharts\Options\Theme;
use ievtds\Apexcharts\Options\Title;
use ievtds\Apexcharts\Options\Tooltip;
use ievtds\Apexcharts\Options\Xaxis;
use ievtds\Apexcharts\Options\Yaxis;
use ievtds\Apexcharts\Support\DatasetClass;
use ievtds\Apexcharts\Traits\Formatter;
use ievtds\Apexcharts\Traits\Types;
use Balping\JsonRaw\Encoder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

class Chart
{
    use Annotations, ChartOption, DataLabels, Fill, ForecastDataPoints, Grid, Legend, Markers, NoData, PlotOptions, Responsive, States, Stroke, Subtitle, Theme, Title, Tooltip, Xaxis, Yaxis, Formatter, Types;

    public string $id;

    public string $type = 'line';

    public array $colors = [];

    public array $labels = [];

    public array $series = [];

    public array $datasets = [];

    public string $dataset = DatasetClass::class;

    public array $options = [];

    public string $container = 'apexcharts::container';

    public string $chartLetters = 'abcdefghijklmnopqrstuvwxyz';

    public function __construct()
    {
        $this->id = substr(str_shuffle(str_repeat($x = $this->chartLetters, ceil(25 / strlen($x)))), 1, 25);

        $this->options = config('apexcharts.options');
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setType(string|null $type = null): Chart
    {
        $this->type = $type;

        $this->setOption([
            'chart' => [
                'type' => $type,
            ],
        ]);

        return $this;
    }

    public function getType(): string
    {
        return $this->type ? $this->type : $this->datasets[0]->type;
    }

    public function setColor(string $color): Chart
    {
        $colors = $this->colors;

        $colors[] = $color;

        return $this->setColors($colors);
    }

    public function setColors(array $colors): Chart
    {
        $this->colors = $colors;

        $this->setOption([
            'colors' => $colors,
        ]);

        return $this;
    }

    public function getColors(): array
    {
        return $this->colors;
    }

    public function setLabels(array $labels): Chart
    {
        $this->labels = $labels;

        $this->setOption([
            'labels' => $labels,
        ]);

        return $this;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setSeries(array $series): Chart
    {
        $this->series = $series;

        $this->setOption([
            'series' => $series,
        ]);

        return $this;
    }

    public function getSeries(): array
    {
        return $this->series;
    }

    public function setDataset(string $name, string $type, array|Collection $data): Chart
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        if ($type == 'donut') {
            return $this->setSeries($data);
        }

        $dataset = new $this->dataset($name, $type, $data);

        array_push($this->datasets, $dataset);

        return $this->setSeries($this->datasets);
    }

    public function setOption(array|Collection $options = []): Chart
    {
        if ($options instanceof Collection) {
            $options = $options->toArray();
        }

        $this->options = array_replace_recursive($this->options, $options);

        return $this;
    }

    public function setOptions(array|Collection $options = [], bool $overwrite = false): Chart
    {
        if ($options instanceof Collection) {
            $options = $options->toArray();
        }

        if ($overwrite) {
            $this->options = $options;
        } else {
            $this->options = array_replace_recursive($this->options, $options);
        }

        return $this;
    }

    public function getOptions(): string
    {
        return Encoder::encode($this->options);
    }

    public function container(string $container = null): Chart|View
    {
        if (! $container) {
            return ViewFacade::make($this->container, ['chart' => $this]);
        }

        $this->container = $container;

        return $this;
    }

    public function script(): View
    {
        return ViewFacade::make('apexcharts::script', ['chart' => $this]);
    }

    public static function loadScript(): string
    {
        $path = 'https://cdn.jsdelivr.net/npm/apexcharts';

        if (is_file('public/vendor/apexcharts/apexcharts.js')) {
            $path = asset('public/vendor/apexcharts/apexcharts.js');
        }

        return '<script src="' . $path . '"></script>';
    }
}
