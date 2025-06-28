<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Str;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class MapInput extends Input
{
    protected string $view = 'map-input';

    public float $defaultMapCenterLat;
    public float $defaultMapCenterLng;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        public string $latName = 'lat',
        public string $lngName = 'lng',
        public string $radiusName = 'radius',
        public string $polygonName = 'boundary',
        public bool $disabled = false,
        public bool $enableCoordinates = true,
        public bool $enableRadius = false,
        public bool $enablePolygon = false,
        public bool $hideInputs = false,
        public int $radiusPrecision = 0,
        public int  $maxRadius = 6371000,
        public string $radiusUnit = 'm',
        public ?float $lat = null,
        public ?float $lng = null,
        public ?float $radius = null,
        public ?string $polygon = null,
        public ?float $defaultLat = null,
        public ?float $defaultLng = null,
        public ?float $defaultRadius = null,
        public ?string $defaultPolygon = null,
        ?float $defaultMapCenterLat = null,
        ?float $defaultMapCenterLng = null,
        string $label = '',
        $model = null,
        bool $showErrors = true,
        bool $showLabel = true,
        bool $required = false,
        bool $inline = false,
        string $inlineLabelClass = '',
        string $inlineInputClass = '',
        bool $showJsErrors = false,
        string $framework = ''
    ) {
        parent::__construct(
            $name,
            label: $label,
            type: 'map-input',
            model: $model,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required:$required,
            inline: $inline,
            floating: false,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            showJsErrors: $showJsErrors,
            framework: $framework
        );

        $this->defaultMapCenterLat = is_null($defaultMapCenterLat) ? (float) get_setting('default_lat') : $defaultMapCenterLat;
        $this->defaultMapCenterLng = is_null($defaultMapCenterLng) ? (float) get_setting('default_lng') : $defaultMapCenterLng;

        $this->setLat($this->latName, $model, $this->defaultLat);
        $this->setLng($this->lngName, $model, $this->defaultLng);
        $this->setPolygon($this->polygonName, $model, $this->defaultPolygon);
        $this->setRadius($this->radiusName, $model, $this->defaultRadius);
    }

    protected function setLat(string $name, $bind = null, $default = null)
    {
        // try to get from lat input
        $latValue = $this->getValue($name, $bind, $default);

        // try from main value
        if (is_null($latValue) && $this->value instanceof Point) {
            $latValue = $this->value->latitude;
        }

        $this->lat = $latValue;
    }

    protected function setLng(string $name, $bind = null, $default = null)
    {
        // try to get from lng input
        $lngValue = $this->getValue($name, $bind, $default);

        // try from main value
        if (is_null($lngValue) && $this->value instanceof Point) {
            $lngValue = $this->value->longitude;
        }

        $this->lng = $lngValue;
    }

    protected function setPolygon(string $name, $bind = null, $default = null)
    {
        // try to get from polygon input
        $polygonValue = $this->getValue($name, $bind, $default);

        // convert to wkt
        if ($polygonValue instanceof Polygon) {
            $polygonValue = $polygonValue->toWkt();
        }

        $this->polygon = $polygonValue;
    }

    protected function setRadius(string $name, $bind = null, $default = null)
    {
        // try to get from radius input
        $this->radius = $this->getValue($name, $bind, $default);
    }

    public function getRadiusStep(): string
    {
        if ($places = $this->radiusPrecision) {
            return '0.' . Str::repeat('0', $places - 1) . '1';
        }

        return '1';
    }
}
