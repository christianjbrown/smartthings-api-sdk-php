<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ZigbeeManufacturerFingerprint implements ZigbeeManufacturerFingerprintInterface
{
    private ?DeviceIntegrationProfileKeyInterface $deviceIntegrationProfileKey = null;
    private ?string $manufacturer = null;
    private ?string $model = null;

    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface
    {
        return $this->deviceIntegrationProfileKey;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): ZigbeeManufacturerFingerprintInterface
    {
        $this->deviceIntegrationProfileKey = $value;

        return $this;
    }

    public function setManufacturer(?string $value): ZigbeeManufacturerFingerprintInterface
    {
        $this->manufacturer = $value;

        return $this;
    }

    public function setModel(?string $value): ZigbeeManufacturerFingerprintInterface
    {
        $this->model = $value;

        return $this;
    }
}
