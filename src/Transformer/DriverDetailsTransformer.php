<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\DriverDetails;
use ChristianBrown\SmartThings\Model\DriverDetailsInterface;
use ChristianBrown\SmartThings\Model\DriverFingerprintInterface;
use ChristianBrown\SmartThings\Model\DriverPermissionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DriverDetailsTransformer implements DriverDetailsTransformerInterface
{
    private DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer;
    private DriverFingerprintTransformerInterface $driverFingerprintTransformer;
    private DriverPermissionTransformerInterface $driverPermissionTransformer;

    public function __construct(DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer, DriverPermissionTransformerInterface $driverPermissionTransformer, DriverFingerprintTransformerInterface $driverFingerprintTransformer)
    {
        $this->deviceIntegrationProfileKeyTransformer = $deviceIntegrationProfileKeyTransformer;
        $this->driverPermissionTransformer = $driverPermissionTransformer;
        $this->driverFingerprintTransformer = $driverFingerprintTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverDetailsInterface
    {
        $model = new DriverDetails();

        $this->applyDeviceIntegrationProfiles($model, $data);
        $this->applyPermissions($model, $data);
        $this->applyFingerprints($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceIntegrationProfiles(DriverDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_INTEGRATION_PROFILES])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_INTEGRATION_PROFILES])) {
            return;
        }
        $model->setDeviceIntegrationProfiles($this->transformListDeviceIntegrationProfileKey($data[self::KEY_DEVICE_INTEGRATION_PROFILES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFingerprints(DriverDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_FINGERPRINTS])) {
            return;
        }
        if (!is_array($data[self::KEY_FINGERPRINTS])) {
            return;
        }
        $model->setFingerprints($this->transformListDriverFingerprint($data[self::KEY_FINGERPRINTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPermissions(DriverDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PERMISSIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_PERMISSIONS])) {
            return;
        }
        $model->setPermissions($this->transformListDriverPermission($data[self::KEY_PERMISSIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceIntegrationProfileKeyInterface>
     */
    private function transformListDeviceIntegrationProfileKey(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceIntegrationProfileKeyInterface => $this->deviceIntegrationProfileKeyTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DriverFingerprintInterface>
     */
    private function transformListDriverFingerprint(array $data): array
    {
        return array_values(array_map(fn (array $item): DriverFingerprintInterface => $this->driverFingerprintTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DriverPermissionInterface>
     */
    private function transformListDriverPermission(array $data): array
    {
        return array_values(array_map(fn (array $item): DriverPermissionInterface => $this->driverPermissionTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
