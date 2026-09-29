<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DriverInterface
{
    public function getDescription(): ?string;

    /**
     * @return array<int, DeviceIntegrationProfileKeyInterface>
     */
    public function getDeviceIntegrationProfiles(): array;

    public function getDriverId(): string;

    /**
     * @return array<int, DriverFingerprintInterface>
     */
    public function getFingerprints(): array;

    public function getName(): ?string;

    public function getPackageKey(): ?string;

    /**
     * @return array<int, DriverPermissionInterface>
     */
    public function getPermissions(): array;

    public function getVersion(): ?string;

    public function setDescription(?string $value): self;

    /**
     * @param array<int, DeviceIntegrationProfileKeyInterface> $value
     */
    public function setDeviceIntegrationProfiles(array $value): self;

    public function setDriverId(string $value): self;

    /**
     * @param array<int, DriverFingerprintInterface> $value
     */
    public function setFingerprints(array $value): self;

    public function setName(?string $value): self;

    public function setPackageKey(?string $value): self;

    /**
     * @param array<int, DriverPermissionInterface> $value
     */
    public function setPermissions(array $value): self;

    public function setVersion(?string $value): self;
}
