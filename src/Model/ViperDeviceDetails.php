<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ViperDeviceDetails implements ViperDeviceDetailsInterface
{
    private ?string $endpointAppId = null;
    private ?string $hwVersion = null;
    private ?string $manufacturerName = null;
    private ?string $modelName = null;
    private ?string $swVersion = null;
    private ?string $uniqueIdentifier = null;

    public function getEndpointAppId(): ?string
    {
        return $this->endpointAppId;
    }

    public function getHwVersion(): ?string
    {
        return $this->hwVersion;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function getSwVersion(): ?string
    {
        return $this->swVersion;
    }

    public function getUniqueIdentifier(): ?string
    {
        return $this->uniqueIdentifier;
    }

    public function setEndpointAppId(?string $value): ViperDeviceDetailsInterface
    {
        $this->endpointAppId = $value;

        return $this;
    }

    public function setHwVersion(?string $value): ViperDeviceDetailsInterface
    {
        $this->hwVersion = $value;

        return $this;
    }

    public function setManufacturerName(?string $value): ViperDeviceDetailsInterface
    {
        $this->manufacturerName = $value;

        return $this;
    }

    public function setModelName(?string $value): ViperDeviceDetailsInterface
    {
        $this->modelName = $value;

        return $this;
    }

    public function setSwVersion(?string $value): ViperDeviceDetailsInterface
    {
        $this->swVersion = $value;

        return $this;
    }

    public function setUniqueIdentifier(?string $value): ViperDeviceDetailsInterface
    {
        $this->uniqueIdentifier = $value;

        return $this;
    }
}
