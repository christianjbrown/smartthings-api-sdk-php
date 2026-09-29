<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ViperDeviceDetailsInterface
{
    public function getEndpointAppId(): ?string;

    public function getHwVersion(): ?string;

    public function getManufacturerName(): ?string;

    public function getModelName(): ?string;

    public function getSwVersion(): ?string;

    public function getUniqueIdentifier(): ?string;

    public function setEndpointAppId(?string $value): self;

    public function setHwVersion(?string $value): self;

    public function setManufacturerName(?string $value): self;

    public function setModelName(?string $value): self;

    public function setSwVersion(?string $value): self;

    public function setUniqueIdentifier(?string $value): self;
}
