<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ZigbeeManufacturerFingerprintInterface
{
    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface;

    public function getManufacturer(): ?string;

    public function getModel(): ?string;

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): self;

    public function setManufacturer(?string $value): self;

    public function setModel(?string $value): self;
}
