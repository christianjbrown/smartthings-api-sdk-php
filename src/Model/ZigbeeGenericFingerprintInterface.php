<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ZigbeeGenericFingerprintInterface
{
    public function getClusters(): ?ClustersInterface;

    /**
     * @return null|array<int, int>
     */
    public function getDeviceIdentifiers(): ?array;

    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface;

    /**
     * @return null|array<int, int>
     */
    public function getZigbeeProfiles(): ?array;

    public function setClusters(?ClustersInterface $value): self;

    /**
     * @param null|array<int, int> $value
     */
    public function setDeviceIdentifiers(?array $value): self;

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): self;

    /**
     * @param null|array<int, int> $value
     */
    public function setZigbeeProfiles(?array $value): self;
}
