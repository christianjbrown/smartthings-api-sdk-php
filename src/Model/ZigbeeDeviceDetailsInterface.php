<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ZigbeeDeviceDetailsInterface
{
    public function getDriverId(): ?string;

    public function getEui(): ?string;

    public function getExecutingLocally(): ?bool;

    public function getFingerprintId(): ?string;

    public function getFingerprintType(): ?string;

    public function getHubId(): ?string;

    public function getNetworkId(): ?string;

    public function getProvisioningState(): ?string;

    public function setDriverId(?string $value): self;

    public function setEui(?string $value): self;

    public function setExecutingLocally(?bool $value): self;

    public function setFingerprintId(?string $value): self;

    public function setFingerprintType(?string $value): self;

    public function setHubId(?string $value): self;

    public function setNetworkId(?string $value): self;

    public function setProvisioningState(?string $value): self;
}
