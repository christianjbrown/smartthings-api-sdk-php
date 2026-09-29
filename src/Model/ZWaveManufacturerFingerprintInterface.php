<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ZWaveManufacturerFingerprintInterface
{
    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface;

    public function getManufacturerId(): ?int;

    public function getProductId(): ?int;

    public function getProductType(): int;

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): self;

    public function setManufacturerId(?int $value): self;

    public function setProductId(?int $value): self;
}
