<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DthDeviceDetailsInterface
{
    public function getCompletedSetup(): ?bool;

    public function getDeviceNetworkType(): ?string;

    public function getDeviceTypeId(): ?string;

    public function getDeviceTypeName(): ?string;

    public function getExecutingLocally(): ?bool;

    public function getFingerprintId(): ?string;

    public function getFingerprintType(): ?string;

    public function getHubId(): ?string;

    public function getInstalledGroovyAppId(): ?string;

    public function getNetworkId(): ?string;

    public function getNetworkSecurityLevel(): ?string;

    public function setDeviceNetworkType(?string $value): self;

    public function setExecutingLocally(?bool $value): self;

    public function setFingerprintId(?string $value): self;

    public function setFingerprintType(?string $value): self;

    public function setHubId(?string $value): self;

    public function setInstalledGroovyAppId(?string $value): self;

    public function setNetworkId(?string $value): self;

    public function setNetworkSecurityLevel(?string $value): self;
}
