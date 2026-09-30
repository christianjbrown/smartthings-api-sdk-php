<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DriverFingerprint implements DriverFingerprintInterface
{
    private ?string $deviceLabel = null;
    private ?string $id;
    private ?string $type;
    private ?ZigbeeGenericFingerprintInterface $zigbeeGeneric = null;
    private ?ZigbeeManufacturerFingerprintInterface $zigbeeManfacturer = null;
    private ?ZWaveGenericFingerprintInterface $zwaveGeneric = null;
    private ?ZWaveManufacturerFingerprintInterface $zwaveManufacturer = null;

    public function __construct(?string $id, ?string $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getDeviceLabel(): ?string
    {
        return $this->deviceLabel;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getZigbeeGeneric(): ?ZigbeeGenericFingerprintInterface
    {
        return $this->zigbeeGeneric;
    }

    public function getZigbeeManfacturer(): ?ZigbeeManufacturerFingerprintInterface
    {
        return $this->zigbeeManfacturer;
    }

    public function getZwaveGeneric(): ?ZWaveGenericFingerprintInterface
    {
        return $this->zwaveGeneric;
    }

    public function getZwaveManufacturer(): ?ZWaveManufacturerFingerprintInterface
    {
        return $this->zwaveManufacturer;
    }

    public function setDeviceLabel(?string $value): DriverFingerprintInterface
    {
        $this->deviceLabel = $value;

        return $this;
    }

    public function setZigbeeGeneric(?ZigbeeGenericFingerprintInterface $value): DriverFingerprintInterface
    {
        $this->zigbeeGeneric = $value;

        return $this;
    }

    public function setZigbeeManfacturer(?ZigbeeManufacturerFingerprintInterface $value): DriverFingerprintInterface
    {
        $this->zigbeeManfacturer = $value;

        return $this;
    }

    public function setZwaveGeneric(?ZWaveGenericFingerprintInterface $value): DriverFingerprintInterface
    {
        $this->zwaveGeneric = $value;

        return $this;
    }

    public function setZwaveManufacturer(?ZWaveManufacturerFingerprintInterface $value): DriverFingerprintInterface
    {
        $this->zwaveManufacturer = $value;

        return $this;
    }
}
