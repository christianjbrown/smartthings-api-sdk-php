<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MatterDeviceDetails implements MatterDeviceDetailsInterface
{
    private ?string $driverId = null;

    /**
     * @var null|array<int, MatterEndpointInterface>
     */
    private ?array $endpoints = null;
    private ?bool $executingLocally = null;
    private ?string $fingerprintId = null;
    private ?string $fingerprintType = null;
    private ?string $hubId = null;
    private ?string $listeningType = null;
    private ?string $networkId = null;
    private ?int $productId = null;
    private ?string $provisioningState = null;
    private ?string $serialNumber = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $supportedNetworkInterfaces = null;
    private ?bool $syncDrivers = null;
    private ?string $uniqueId = null;
    private ?int $vendorId = null;
    private ?MatterVersionInterface $version = null;

    public function getDriverId(): ?string
    {
        return $this->driverId;
    }

    /**
     * @return null|array<int, MatterEndpointInterface>
     */
    public function getEndpoints(): ?array
    {
        return $this->endpoints;
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

    public function getListeningType(): ?string
    {
        return $this->listeningType;
    }

    public function getNetworkId(): ?string
    {
        return $this->networkId;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function getProvisioningState(): ?string
    {
        return $this->provisioningState;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    /**
     * @return null|array<int, string>
     */
    public function getSupportedNetworkInterfaces(): ?array
    {
        return $this->supportedNetworkInterfaces;
    }

    public function getSyncDrivers(): ?bool
    {
        return $this->syncDrivers;
    }

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function getVendorId(): ?int
    {
        return $this->vendorId;
    }

    public function getVersion(): ?MatterVersionInterface
    {
        return $this->version;
    }

    public function setDriverId(?string $value): MatterDeviceDetailsInterface
    {
        $this->driverId = $value;

        return $this;
    }

    /**
     * @param null|array<int, MatterEndpointInterface> $value
     */
    public function setEndpoints(?array $value): MatterDeviceDetailsInterface
    {
        $this->endpoints = $value;

        return $this;
    }

    public function setExecutingLocally(?bool $value): MatterDeviceDetailsInterface
    {
        $this->executingLocally = $value;

        return $this;
    }

    public function setFingerprintId(?string $value): MatterDeviceDetailsInterface
    {
        $this->fingerprintId = $value;

        return $this;
    }

    public function setFingerprintType(?string $value): MatterDeviceDetailsInterface
    {
        $this->fingerprintType = $value;

        return $this;
    }

    public function setHubId(?string $value): MatterDeviceDetailsInterface
    {
        $this->hubId = $value;

        return $this;
    }

    public function setListeningType(?string $value): MatterDeviceDetailsInterface
    {
        $this->listeningType = $value;

        return $this;
    }

    public function setNetworkId(?string $value): MatterDeviceDetailsInterface
    {
        $this->networkId = $value;

        return $this;
    }

    public function setProductId(?int $value): MatterDeviceDetailsInterface
    {
        $this->productId = $value;

        return $this;
    }

    public function setProvisioningState(?string $value): MatterDeviceDetailsInterface
    {
        $this->provisioningState = $value;

        return $this;
    }

    public function setSerialNumber(?string $value): MatterDeviceDetailsInterface
    {
        $this->serialNumber = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setSupportedNetworkInterfaces(?array $value): MatterDeviceDetailsInterface
    {
        $this->supportedNetworkInterfaces = $value;

        return $this;
    }

    public function setSyncDrivers(?bool $value): MatterDeviceDetailsInterface
    {
        $this->syncDrivers = $value;

        return $this;
    }

    public function setUniqueId(?string $value): MatterDeviceDetailsInterface
    {
        $this->uniqueId = $value;

        return $this;
    }

    public function setVendorId(?int $value): MatterDeviceDetailsInterface
    {
        $this->vendorId = $value;

        return $this;
    }

    public function setVersion(?MatterVersionInterface $value): MatterDeviceDetailsInterface
    {
        $this->version = $value;

        return $this;
    }
}
