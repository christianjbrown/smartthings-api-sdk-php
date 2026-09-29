<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ZWaveGenericFingerprint implements ZWaveGenericFingerprintInterface
{
    private ?CommandClassesInterface $commandClasses = null;
    private ?DeviceIntegrationProfileKeyInterface $deviceIntegrationProfileKey = null;
    private ?int $genericType = null;

    /**
     * @var null|array<int, int>
     */
    private ?array $specificType = null;

    public function getCommandClasses(): ?CommandClassesInterface
    {
        return $this->commandClasses;
    }

    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface
    {
        return $this->deviceIntegrationProfileKey;
    }

    public function getGenericType(): ?int
    {
        return $this->genericType;
    }

    /**
     * @return null|array<int, int>
     */
    public function getSpecificType(): ?array
    {
        return $this->specificType;
    }

    public function setCommandClasses(?CommandClassesInterface $value): ZWaveGenericFingerprintInterface
    {
        $this->commandClasses = $value;

        return $this;
    }

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): ZWaveGenericFingerprintInterface
    {
        $this->deviceIntegrationProfileKey = $value;

        return $this;
    }

    public function setGenericType(?int $value): ZWaveGenericFingerprintInterface
    {
        $this->genericType = $value;

        return $this;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setSpecificType(?array $value): ZWaveGenericFingerprintInterface
    {
        $this->specificType = $value;

        return $this;
    }
}
