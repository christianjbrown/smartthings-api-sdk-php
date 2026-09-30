<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DriverFingerprintInterface
{
    public function getDeviceLabel(): ?string;

    public function getId(): ?string;

    public function getType(): ?string;

    public function getZigbeeGeneric(): ?ZigbeeGenericFingerprintInterface;

    public function getZigbeeManfacturer(): ?ZigbeeManufacturerFingerprintInterface;

    public function getZwaveGeneric(): ?ZWaveGenericFingerprintInterface;

    public function getZwaveManufacturer(): ?ZWaveManufacturerFingerprintInterface;

    public function setDeviceLabel(?string $value): self;

    public function setZigbeeGeneric(?ZigbeeGenericFingerprintInterface $value): self;

    public function setZigbeeManfacturer(?ZigbeeManufacturerFingerprintInterface $value): self;

    public function setZwaveGeneric(?ZWaveGenericFingerprintInterface $value): self;

    public function setZwaveManufacturer(?ZWaveManufacturerFingerprintInterface $value): self;
}
