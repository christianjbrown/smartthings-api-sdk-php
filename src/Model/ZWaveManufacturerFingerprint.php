<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ZWaveManufacturerFingerprint implements ZWaveManufacturerFingerprintInterface
{
    private ?DeviceIntegrationProfileKeyInterface $deviceIntegrationProfileKey = null;
    private ?int $manufacturerId = null;
    private ?int $productId = null;
    private int $productType;

    public function __construct(int $productType)
    {
        $this->productType = $productType;
    }

    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface
    {
        return $this->deviceIntegrationProfileKey;
    }

    public function getManufacturerId(): ?int
    {
        return $this->manufacturerId;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function getProductType(): int
    {
        return $this->productType;
    }

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): ZWaveManufacturerFingerprintInterface
    {
        $this->deviceIntegrationProfileKey = $value;

        return $this;
    }

    public function setManufacturerId(?int $value): ZWaveManufacturerFingerprintInterface
    {
        $this->manufacturerId = $value;

        return $this;
    }

    public function setProductId(?int $value): ZWaveManufacturerFingerprintInterface
    {
        $this->productId = $value;

        return $this;
    }
}
