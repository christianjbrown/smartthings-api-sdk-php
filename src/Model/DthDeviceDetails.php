<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DthDeviceDetails implements DthDeviceDetailsInterface
{
    private ?bool $completedSetup;
    private ?string $deviceNetworkType = null;
    private ?string $deviceTypeId;
    private ?string $deviceTypeName;
    private ?bool $executingLocally = null;
    private ?string $fingerprintId = null;
    private ?string $fingerprintType = null;
    private ?string $hubId = null;
    private ?string $installedGroovyAppId = null;
    private ?string $networkId = null;
    private ?string $networkSecurityLevel = null;

    public function __construct(?bool $completedSetup, ?string $deviceTypeId, ?string $deviceTypeName)
    {
        $this->completedSetup = $completedSetup;
        $this->deviceTypeId = $deviceTypeId;
        $this->deviceTypeName = $deviceTypeName;
    }

    public function getCompletedSetup(): ?bool
    {
        return $this->completedSetup;
    }

    public function getDeviceNetworkType(): ?string
    {
        return $this->deviceNetworkType;
    }

    public function getDeviceTypeId(): ?string
    {
        return $this->deviceTypeId;
    }

    public function getDeviceTypeName(): ?string
    {
        return $this->deviceTypeName;
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

    public function getInstalledGroovyAppId(): ?string
    {
        return $this->installedGroovyAppId;
    }

    public function getNetworkId(): ?string
    {
        return $this->networkId;
    }

    public function getNetworkSecurityLevel(): ?string
    {
        return $this->networkSecurityLevel;
    }

    public function setDeviceNetworkType(?string $value): DthDeviceDetailsInterface
    {
        $this->deviceNetworkType = $value;

        return $this;
    }

    public function setExecutingLocally(?bool $value): DthDeviceDetailsInterface
    {
        $this->executingLocally = $value;

        return $this;
    }

    public function setFingerprintId(?string $value): DthDeviceDetailsInterface
    {
        $this->fingerprintId = $value;

        return $this;
    }

    public function setFingerprintType(?string $value): DthDeviceDetailsInterface
    {
        $this->fingerprintType = $value;

        return $this;
    }

    public function setHubId(?string $value): DthDeviceDetailsInterface
    {
        $this->hubId = $value;

        return $this;
    }

    public function setInstalledGroovyAppId(?string $value): DthDeviceDetailsInterface
    {
        $this->installedGroovyAppId = $value;

        return $this;
    }

    public function setNetworkId(?string $value): DthDeviceDetailsInterface
    {
        $this->networkId = $value;

        return $this;
    }

    public function setNetworkSecurityLevel(?string $value): DthDeviceDetailsInterface
    {
        $this->networkSecurityLevel = $value;

        return $this;
    }
}
