<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ZigbeeGenericFingerprint implements ZigbeeGenericFingerprintInterface
{
    private ?ClustersInterface $clusters = null;

    /**
     * @var null|array<int, int>
     */
    private ?array $deviceIdentifiers = null;
    private ?DeviceIntegrationProfileKeyInterface $deviceIntegrationProfileKey = null;

    /**
     * @var null|array<int, int>
     */
    private ?array $zigbeeProfiles = null;

    public function getClusters(): ?ClustersInterface
    {
        return $this->clusters;
    }

    /**
     * @return null|array<int, int>
     */
    public function getDeviceIdentifiers(): ?array
    {
        return $this->deviceIdentifiers;
    }

    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface
    {
        return $this->deviceIntegrationProfileKey;
    }

    /**
     * @return null|array<int, int>
     */
    public function getZigbeeProfiles(): ?array
    {
        return $this->zigbeeProfiles;
    }

    public function setClusters(?ClustersInterface $value): ZigbeeGenericFingerprintInterface
    {
        $this->clusters = $value;

        return $this;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setDeviceIdentifiers(?array $value): ZigbeeGenericFingerprintInterface
    {
        $this->deviceIdentifiers = $value;

        return $this;
    }

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): ZigbeeGenericFingerprintInterface
    {
        $this->deviceIntegrationProfileKey = $value;

        return $this;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setZigbeeProfiles(?array $value): ZigbeeGenericFingerprintInterface
    {
        $this->zigbeeProfiles = $value;

        return $this;
    }
}
