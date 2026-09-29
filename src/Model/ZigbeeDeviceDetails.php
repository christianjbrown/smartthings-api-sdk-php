<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ZigbeeDeviceDetails implements ZigbeeDeviceDetailsInterface
{
    private ?string $driverId = null;
    private ?string $eui = null;
    private ?bool $executingLocally = null;
    private ?string $fingerprintId = null;
    private ?string $fingerprintType = null;
    private ?string $hubId = null;
    private ?string $networkId = null;
    private ?string $provisioningState = null;

    public function getDriverId(): ?string
    {
        return $this->driverId;
    }

    public function getEui(): ?string
    {
        return $this->eui;
    }

    public function getExecutingLocally(): ?bool
    {
        return $this->executingLocally;
    }

    public function getFingerprintId(): ?string
    {
        return $this->fingerprintId;
    }

    public function getFingerprintType(): ?string
    {
        return $this->fingerprintType;
    }

    public function getHubId(): ?string
    {
        return $this->hubId;
    }

    public function getNetworkId(): ?string
    {
        return $this->networkId;
    }

    public function getProvisioningState(): ?string
    {
        return $this->provisioningState;
    }

    public function setDriverId(?string $value): ZigbeeDeviceDetailsInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setEui(?string $value): ZigbeeDeviceDetailsInterface
    {
        $this->eui = $value;

        return $this;
    }

    public function setExecutingLocally(?bool $value): ZigbeeDeviceDetailsInterface
    {
        $this->executingLocally = $value;

        return $this;
    }

    public function setFingerprintId(?string $value): ZigbeeDeviceDetailsInterface
    {
        $this->fingerprintId = $value;

        return $this;
    }

    public function setFingerprintType(?string $value): ZigbeeDeviceDetailsInterface
    {
        $this->fingerprintType = $value;

        return $this;
    }

    public function setHubId(?string $value): ZigbeeDeviceDetailsInterface
    {
        $this->hubId = $value;

        return $this;
    }

    public function setNetworkId(?string $value): ZigbeeDeviceDetailsInterface
    {
        $this->networkId = $value;

        return $this;
    }

    public function setProvisioningState(?string $value): ZigbeeDeviceDetailsInterface
    {
        $this->provisioningState = $value;

        return $this;
    }
}
