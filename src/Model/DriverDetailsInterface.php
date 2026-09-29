<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DriverDetailsInterface
{
    /**
     * @return null|array<int, DeviceIntegrationProfileKeyInterface>
     */
    public function getDeviceIntegrationProfiles(): ?array;

    /**
     * @return null|array<int, DriverFingerprintInterface>
     */
    public function getFingerprints(): ?array;

    /**
     * @return null|array<int, DriverPermissionInterface>
     */
    public function getPermissions(): ?array;

    /**
     * @param null|array<int, DeviceIntegrationProfileKeyInterface> $value
     */
    public function setDeviceIntegrationProfiles(?array $value): self;

    /**
     * @param null|array<int, DriverFingerprintInterface> $value
     */
    public function setFingerprints(?array $value): self;

    /**
     * @param null|array<int, DriverPermissionInterface> $value
     */
    public function setPermissions(?array $value): self;
}
