<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Driver implements DriverInterface
{
    private ?string $description = null;

    /**
     * @var array<int, DeviceIntegrationProfileKeyInterface>
     */
    private array $deviceIntegrationProfiles = [];
    private string $driverId;

    /**
     * @var array<int, DriverFingerprintInterface>
     */
    private array $fingerprints = [];
    private ?string $name = null;
    private ?string $packageKey = null;

    /**
     * @var array<int, DriverPermissionInterface>
     */
    private array $permissions = [];
    private ?string $version = null;

    public function __construct(string $driverId)
    {
        $this->driverId = $driverId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array<int, DeviceIntegrationProfileKeyInterface>
     */
    public function getDeviceIntegrationProfiles(): array
    {
        return $this->deviceIntegrationProfiles;
    }

    public function getDriverId(): string
    {
        return $this->driverId;
    }

    /**
     * @return array<int, DriverFingerprintInterface>
     */
    public function getFingerprints(): array
    {
        return $this->fingerprints;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPackageKey(): ?string
    {
        return $this->packageKey;
    }

    /**
     * @return array<int, DriverPermissionInterface>
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setDescription(?string $value): DriverInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param array<int, DeviceIntegrationProfileKeyInterface> $value
     */
    public function setDeviceIntegrationProfiles(array $value): DriverInterface
    {
        $this->deviceIntegrationProfiles = $value;

        return $this;
    }

    public function setDriverId(string $value): DriverInterface
    {
        $this->driverId = $value;

        return $this;
    }

    /**
     * @param array<int, DriverFingerprintInterface> $value
     */
    public function setFingerprints(array $value): DriverInterface
    {
        $this->fingerprints = $value;

        return $this;
    }

    public function setName(?string $value): DriverInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setPackageKey(?string $value): DriverInterface
    {
        $this->packageKey = $value;

        return $this;
    }

    /**
     * @param array<int, DriverPermissionInterface> $value
     */
    public function setPermissions(array $value): DriverInterface
    {
        $this->permissions = $value;

        return $this;
    }

    public function setVersion(?string $value): DriverInterface
    {
        $this->version = $value;

        return $this;
    }
}
