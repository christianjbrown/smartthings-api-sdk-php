<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EdgeChildDeviceDetails implements EdgeChildDeviceDetailsInterface
{
    private ?string $driverId = null;
    private ?bool $executingLocally = null;
    private ?string $fingerprintId = null;
    private ?string $fingerprintType = null;
    private ?string $hubId = null;
    private ?string $networkId = null;
    private ?string $parentAssignedChildKey = null;
    private ?string $provisioningState = null;

    public function getDriverId(): ?string
    {
        return $this->driverId;
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

    public function getParentAssignedChildKey(): ?string
    {
        return $this->parentAssignedChildKey;
    }

    public function getProvisioningState(): ?string
    {
        return $this->provisioningState;
    }

    public function setDriverId(?string $value): EdgeChildDeviceDetailsInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setExecutingLocally(?bool $value): EdgeChildDeviceDetailsInterface
    {
        $this->executingLocally = $value;

        return $this;
    }

    public function setFingerprintId(?string $value): EdgeChildDeviceDetailsInterface
    {
        $this->fingerprintId = $value;

        return $this;
    }

    public function setFingerprintType(?string $value): EdgeChildDeviceDetailsInterface
    {
        $this->fingerprintType = $value;

        return $this;
    }

    public function setHubId(?string $value): EdgeChildDeviceDetailsInterface
    {
        $this->hubId = $value;

        return $this;
    }

    public function setNetworkId(?string $value): EdgeChildDeviceDetailsInterface
    {
        $this->networkId = $value;

        return $this;
    }

    public function setParentAssignedChildKey(?string $value): EdgeChildDeviceDetailsInterface
    {
        $this->parentAssignedChildKey = $value;

        return $this;
    }

    public function setProvisioningState(?string $value): EdgeChildDeviceDetailsInterface
    {
        $this->provisioningState = $value;

        return $this;
    }
}
