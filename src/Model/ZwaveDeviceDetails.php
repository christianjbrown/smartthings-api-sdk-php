<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ZwaveDeviceDetails implements ZwaveDeviceDetailsInterface
{
    private ?string $driverId = null;
    private ?bool $executingLocally = null;
    private ?string $fingerprintId = null;
    private ?string $fingerprintType = null;
    private ?string $hubId = null;
    private ?int $manufacturerId = null;
    private ?string $networkId = null;
    private ?string $networkSecurityLevel = null;
    private ?int $productId = null;
    private ?int $productType = null;
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

    public function getManufacturerId(): ?int
    {
        return $this->manufacturerId;
    }

    public function getNetworkId(): ?string
    {
        return $this->networkId;
    }

    public function getNetworkSecurityLevel(): ?string
    {
        return $this->networkSecurityLevel;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function getProductType(): ?int
    {
        return $this->productType;
    }

    public function getProvisioningState(): ?string
    {
        return $this->provisioningState;
    }

    public function setDriverId(?string $value): ZwaveDeviceDetailsInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setExecutingLocally(?bool $value): ZwaveDeviceDetailsInterface
    {
        $this->executingLocally = $value;

        return $this;
    }

    public function setFingerprintId(?string $value): ZwaveDeviceDetailsInterface
    {
        $this->fingerprintId = $value;

        return $this;
    }

    public function setFingerprintType(?string $value): ZwaveDeviceDetailsInterface
    {
        $this->fingerprintType = $value;

        return $this;
    }

    public function setHubId(?string $value): ZwaveDeviceDetailsInterface
    {
        $this->hubId = $value;

        return $this;
    }

    public function setManufacturerId(?int $value): ZwaveDeviceDetailsInterface
    {
        $this->manufacturerId = $value;

        return $this;
    }

    public function setNetworkId(?string $value): ZwaveDeviceDetailsInterface
    {
        $this->networkId = $value;

        return $this;
    }

    public function setNetworkSecurityLevel(?string $value): ZwaveDeviceDetailsInterface
    {
        $this->networkSecurityLevel = $value;

        return $this;
    }

    public function setProductId(?int $value): ZwaveDeviceDetailsInterface
    {
        $this->productId = $value;

        return $this;
    }

    public function setProductType(?int $value): ZwaveDeviceDetailsInterface
    {
        $this->productType = $value;

        return $this;
    }

    public function setProvisioningState(?string $value): ZwaveDeviceDetailsInterface
    {
        $this->provisioningState = $value;

        return $this;
    }
}
