<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DriverDetails implements DriverDetailsInterface
{
    /**
     * @var null|array<int, DeviceIntegrationProfileKeyInterface>
     */
    private ?array $deviceIntegrationProfiles = null;

    /**
     * @var null|array<int, DriverFingerprintInterface>
     */
    private ?array $fingerprints = null;

    /**
     * @var null|array<int, DriverPermissionInterface>
     */
    private ?array $permissions = null;

    /**
     * @return null|array<int, DeviceIntegrationProfileKeyInterface>
     */
    public function getDeviceIntegrationProfiles(): ?array
    {
        return $this->deviceIntegrationProfiles;
    }

    /**
     * @return null|array<int, DriverFingerprintInterface>
     */
    public function getFingerprints(): ?array
    {
        return $this->fingerprints;
    }

    /**
     * @return null|array<int, DriverPermissionInterface>
     */
    public function getPermissions(): ?array
    {
        return $this->permissions;
    }

    /**
     * @param null|array<int, DeviceIntegrationProfileKeyInterface> $value
     */
    public function setDeviceIntegrationProfiles(?array $value): DriverDetailsInterface
    {
        $this->deviceIntegrationProfiles = $value;

        return $this;
    }

    /**
     * @param null|array<int, DriverFingerprintInterface> $value
     */
    public function setFingerprints(?array $value): DriverDetailsInterface
    {
        $this->fingerprints = $value;

        return $this;
    }

    /**
     * @param null|array<int, DriverPermissionInterface> $value
     */
    public function setPermissions(?array $value): DriverDetailsInterface
    {
        $this->permissions = $value;

        return $this;
    }
}
