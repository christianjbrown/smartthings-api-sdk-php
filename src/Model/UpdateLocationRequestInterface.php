<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateLocationRequestInterface
{
    /**
     * @return null|array<string, string>
     */
    public function getAdditionalProperties(): ?array;

    public function getLatitude(): ?float;

    public function getLocale(): ?string;

    public function getLongitude(): ?float;

    public function getName(): string;

    public function getRegionRadius(): ?int;

    public function getTemperatureScale(): ?string;

    public function getTimeZoneId(): ?string;

    /**
     * @param null|array<string, string> $value
     */
    public function setAdditionalProperties(?array $value): self;

    public function setLatitude(?float $value): self;

    public function setLocale(?string $value): self;

    public function setLongitude(?float $value): self;

    public function setRegionRadius(?int $value): self;

    public function setTemperatureScale(?string $value): self;

    public function setTimeZoneId(?string $value): self;
}
