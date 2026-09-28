<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateLocationRequest implements UpdateLocationRequestInterface
{
    private ?float $latitude = null;
    private ?string $locale = null;
    private ?float $longitude = null;
    private string $name;
    private ?int $regionRadius = null;
    private ?string $temperatureScale = null;
    private ?string $timeZoneId = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRegionRadius(): ?int
    {
        return $this->regionRadius;
    }

    public function getTemperatureScale(): ?string
    {
        return $this->temperatureScale;
    }

    public function getTimeZoneId(): ?string
    {
        return $this->timeZoneId;
    }

    public function setLatitude(?float $value): UpdateLocationRequestInterface
    {
        $this->latitude = $value;

        return $this;
    }

    public function setLocale(?string $value): UpdateLocationRequestInterface
    {
        $this->locale = $value;

        return $this;
    }

    public function setLongitude(?float $value): UpdateLocationRequestInterface
    {
        $this->longitude = $value;

        return $this;
    }

    public function setRegionRadius(?int $value): UpdateLocationRequestInterface
    {
        $this->regionRadius = $value;

        return $this;
    }

    public function setTemperatureScale(?string $value): UpdateLocationRequestInterface
    {
        $this->temperatureScale = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): UpdateLocationRequestInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }
}
