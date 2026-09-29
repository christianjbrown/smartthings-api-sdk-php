<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ZwaveDeviceDetailsInterface
{
    public function getDriverId(): ?string;

    public function getExecutingLocally(): ?bool;

    public function getFingerprintId(): ?string;

    public function getFingerprintType(): ?string;

    public function getHubId(): ?string;

    public function getManufacturerId(): ?int;

    public function getNetworkId(): ?string;

    public function getNetworkSecurityLevel(): ?string;

    public function getProductId(): ?int;

    public function getProductType(): ?int;

    public function getProvisioningState(): ?string;

    public function setDriverId(?string $value): self;

    public function setExecutingLocally(?bool $value): self;

    public function setFingerprintId(?string $value): self;

    public function setFingerprintType(?string $value): self;

    public function setHubId(?string $value): self;

    public function setManufacturerId(?int $value): self;

    public function setNetworkId(?string $value): self;

    public function setNetworkSecurityLevel(?string $value): self;

    public function setProductId(?int $value): self;

    public function setProductType(?int $value): self;

    public function setProvisioningState(?string $value): self;
}
