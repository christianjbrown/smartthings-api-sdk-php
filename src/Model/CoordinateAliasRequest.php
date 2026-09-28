<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CoordinateAliasRequest implements CoordinateAliasRequestInterface
{
    private float $latitude;
    private float $longitude;
    private int $regionRadius;

    public function __construct(float $latitude, float $longitude, int $regionRadius)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->regionRadius = $regionRadius;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getRegionRadius(): int
    {
        return $this->regionRadius;
    }
}
