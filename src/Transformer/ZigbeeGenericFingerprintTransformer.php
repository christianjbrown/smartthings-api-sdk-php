<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZigbeeGenericFingerprint;
use ChristianBrown\SmartThings\Model\ZigbeeGenericFingerprintInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_int;

final class ZigbeeGenericFingerprintTransformer implements ZigbeeGenericFingerprintTransformerInterface
{
    private ClustersTransformerInterface $clustersTransformer;
    private DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer;

    public function __construct(ClustersTransformerInterface $clustersTransformer, DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer)
    {
        $this->clustersTransformer = $clustersTransformer;
        $this->deviceIntegrationProfileKeyTransformer = $deviceIntegrationProfileKeyTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZigbeeGenericFingerprintInterface
    {
        $model = new ZigbeeGenericFingerprint();

        $this->applyClusters($model, $data);
        self::applyDeviceIdentifiers($model, $data);
        self::applyZigbeeProfiles($model, $data);
        $this->applyDeviceIntegrationProfileKey($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyClusters(ZigbeeGenericFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_CLUSTERS])) {
            return;
        }
        if (!is_array($data[self::KEY_CLUSTERS])) {
            return;
        }
        $model->setClusters($this->clustersTransformer->transform($data[self::KEY_CLUSTERS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceIdentifiers(ZigbeeGenericFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_IDENTIFIERS])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_IDENTIFIERS])) {
            return;
        }
        $model->setDeviceIdentifiers(array_values(array_filter($data[self::KEY_DEVICE_IDENTIFIERS], is_int(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceIntegrationProfileKey(ZigbeeGenericFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_INTEGRATION_PROFILE_KEY])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_INTEGRATION_PROFILE_KEY])) {
            return;
        }
        $model->setDeviceIntegrationProfileKey($this->deviceIntegrationProfileKeyTransformer->transform($data[self::KEY_DEVICE_INTEGRATION_PROFILE_KEY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeProfiles(ZigbeeGenericFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_PROFILES])) {
            return;
        }
        if (!is_array($data[self::KEY_ZIGBEE_PROFILES])) {
            return;
        }
        $model->setZigbeeProfiles(array_values(array_filter($data[self::KEY_ZIGBEE_PROFILES], is_int(...))));
    }
}
