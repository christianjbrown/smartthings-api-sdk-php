<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MatterDeviceDetailsInterface
{
    public function getDriverId(): ?string;

    /**
     * @return null|array<int, MatterEndpointInterface>
     */
    public function getEndpoints(): ?array;

    public function getExecutingLocally(): ?bool;

    public function getFingerprintId(): ?string;

    public function getFingerprintType(): ?string;

    public function getHubId(): ?string;

    public function getListeningType(): ?string;

    public function getNetworkId(): ?string;

    public function getProductId(): ?int;

    public function getProvisioningState(): ?string;

    public function getSerialNumber(): ?string;

    /**
     * @return null|array<int, string>
     */
    public function getSupportedNetworkInterfaces(): ?array;

    public function getSyncDrivers(): ?bool;

    public function getUniqueId(): ?string;

    public function getVendorId(): ?int;

    public function getVersion(): ?MatterVersionInterface;

    public function setDriverId(?string $value): self;

    /**
     * @param null|array<int, MatterEndpointInterface> $value
     */
    public function setEndpoints(?array $value): self;

    public function setExecutingLocally(?bool $value): self;

    public function setFingerprintId(?string $value): self;

    public function setFingerprintType(?string $value): self;

    public function setHubId(?string $value): self;

    public function setListeningType(?string $value): self;

    public function setNetworkId(?string $value): self;

    public function setProductId(?int $value): self;

    public function setProvisioningState(?string $value): self;

    public function setSerialNumber(?string $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setSupportedNetworkInterfaces(?array $value): self;

    public function setSyncDrivers(?bool $value): self;

    public function setUniqueId(?string $value): self;

    public function setVendorId(?int $value): self;

    public function setVersion(?MatterVersionInterface $value): self;
}
