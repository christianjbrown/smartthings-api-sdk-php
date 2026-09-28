<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateLocationRequest implements CreateLocationRequestInterface
{
    private string $countryCode;
    private ?float $latitude = null;
    private ?string $locale = null;
    private ?float $longitude = null;
    private string $name;
    private ?int $regionRadius = null;
    private ?string $temperatureScale = null;
    private ?string $timeZoneId = null;

    public function __construct(string $name, string $countryCode)
    {
        $this->name = $name;
        $this->countryCode = $countryCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
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

    public function setLatitude(?float $value): CreateLocationRequestInterface
    {
        $this->latitude = $value;

        return $this;
    }

    public function setLocale(?string $value): CreateLocationRequestInterface
    {
        $this->locale = $value;

        return $this;
    }

    public function setLongitude(?float $value): CreateLocationRequestInterface
    {
        $this->longitude = $value;

        return $this;
    }

    public function setRegionRadius(?int $value): CreateLocationRequestInterface
    {
        $this->regionRadius = $value;

        return $this;
    }

    public function setTemperatureScale(?string $value): CreateLocationRequestInterface
    {
        $this->temperatureScale = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): CreateLocationRequestInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }
}
