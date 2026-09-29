<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZWaveGenericFingerprint;
use ChristianBrown\SmartThings\Model\ZWaveGenericFingerprintInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_int;

final class ZWaveGenericFingerprintTransformer implements ZWaveGenericFingerprintTransformerInterface
{
    private CommandClassesTransformerInterface $commandClassesTransformer;
    private DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer;

    public function __construct(CommandClassesTransformerInterface $commandClassesTransformer, DeviceIntegrationProfileKeyTransformerInterface $deviceIntegrationProfileKeyTransformer)
    {
        $this->commandClassesTransformer = $commandClassesTransformer;
        $this->deviceIntegrationProfileKeyTransformer = $deviceIntegrationProfileKeyTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZWaveGenericFingerprintInterface
    {
        $model = new ZWaveGenericFingerprint();

        self::applyGenericType($model, $data);
        self::applySpecificType($model, $data);
        $this->applyCommandClasses($model, $data);
        $this->applyDeviceIntegrationProfileKey($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCommandClasses(ZWaveGenericFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_COMMAND_CLASSES])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMAND_CLASSES])) {
            return;
        }
        $model->setCommandClasses($this->commandClassesTransformer->transform($data[self::KEY_COMMAND_CLASSES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceIntegrationProfileKey(ZWaveGenericFingerprint $model, array $data): void
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
    private static function applyGenericType(ZWaveGenericFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_GENERIC_TYPE])) {
            return;
        }
        if (!is_int($data[self::KEY_GENERIC_TYPE])) {
            return;
        }
        $model->setGenericType($data[self::KEY_GENERIC_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySpecificType(ZWaveGenericFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_SPECIFIC_TYPE])) {
            return;
        }
        if (!is_array($data[self::KEY_SPECIFIC_TYPE])) {
            return;
        }
        $model->setSpecificType(array_values(array_filter($data[self::KEY_SPECIFIC_TYPE], is_int(...))));
    }
}
