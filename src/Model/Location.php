<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Location implements LocationInterface
{
    /**
     * @var array<array-key, string>
     */
    private array $additionalProperties = [];

    /**
     * @var array<int, string>
     */
    private array $allowed = [];
    private ?string $backgroundImage = null;
    private ?string $countryCode = null;
    private ?string $created = null;
    private ?string $lastModified = null;
    private ?float $latitude = null;
    private ?string $locale = null;
    private string $locationId;
    private ?float $longitude = null;
    private ?string $name = null;
    private ?LocationParentInterface $parent = null;
    private ?int $regionRadius = null;
    private ?string $temperatureScale = null;
    private ?string $timeZoneId = null;

    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return array<array-key, string>
     */
    public function getAdditionalProperties(): array
    {
        return $this->additionalProperties;
    }

    /**
     * @return array<int, string>
     */
    public function getAllowed(): array
    {
        return $this->allowed;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getCreated(): ?string
    {
        return $this->created;
    }

    public function getLastModified(): ?string
    {
        return $this->lastModified;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getParent(): ?LocationParentInterface
    {
        return $this->parent;
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

    /**
     * @param array<array-key, string> $value
     */
    public function setAdditionalProperties(array $value): LocationInterface
    {
        $this->additionalProperties = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): LocationInterface
    {
        $this->allowed = $value;

        return $this;
    }

    public function setBackgroundImage(?string $value): LocationInterface
    {
        $this->backgroundImage = $value;

        return $this;
    }

    public function setCountryCode(?string $value): LocationInterface
    {
        $this->countryCode = $value;

        return $this;
    }

    public function setCreated(?string $value): LocationInterface
    {
        $this->created = $value;

        return $this;
    }

    public function setLastModified(?string $value): LocationInterface
    {
        $this->lastModified = $value;

        return $this;
    }

    public function setLatitude(?float $value): LocationInterface
    {
        $this->latitude = $value;

        return $this;
    }

    public function setLocale(?string $value): LocationInterface
    {
        $this->locale = $value;

        return $this;
    }

    public function setLocationId(string $value): LocationInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setLongitude(?float $value): LocationInterface
    {
        $this->longitude = $value;

        return $this;
    }

    public function setName(?string $value): LocationInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setParent(?LocationParentInterface $value): LocationInterface
    {
        $this->parent = $value;

        return $this;
    }

    public function setRegionRadius(?int $value): LocationInterface
    {
        $this->regionRadius = $value;

        return $this;
    }

    public function setTemperatureScale(?string $value): LocationInterface
    {
        $this->temperatureScale = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): LocationInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }
}
