<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationInterface
{
    /**
     * @return array<array-key, string>
     */
    public function getAdditionalProperties(): array;

    /**
     * @return array<int, string>
     */
    public function getAllowed(): array;

    public function getBackgroundImage(): ?string;

    public function getCountryCode(): ?string;

    public function getCreated(): ?string;

    public function getLastModified(): ?string;

    public function getLatitude(): ?float;

    public function getLocale(): ?string;

    public function getLocationId(): string;

    public function getLongitude(): ?float;

    public function getName(): ?string;

    public function getParent(): ?LocationParentInterface;

    public function getRegionRadius(): ?int;

    public function getTemperatureScale(): ?string;

    public function getTimeZoneId(): ?string;

    /**
     * @param array<array-key, string> $value
     */
    public function setAdditionalProperties(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): self;

    public function setBackgroundImage(?string $value): self;

    public function setCountryCode(?string $value): self;

    public function setCreated(?string $value): self;

    public function setLastModified(?string $value): self;

    public function setLatitude(?float $value): self;

    public function setLocale(?string $value): self;

    public function setLocationId(string $value): self;

    public function setLongitude(?float $value): self;

    public function setName(?string $value): self;

    public function setParent(?LocationParentInterface $value): self;

    public function setRegionRadius(?int $value): self;

    public function setTemperatureScale(?string $value): self;

    public function setTimeZoneId(?string $value): self;
}
