<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileDetails;
use ChristianBrown\SmartThings\Model\DeviceProfileDetailsInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DeviceProfileDetailsTransformer implements DeviceProfileDetailsTransformerInterface
{
    private DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer;
    private DeviceProfileComponentTransformerInterface $deviceProfileComponentTransformer;
    private DeviceRestrictionTransformerInterface $deviceRestrictionTransformer;

    public function __construct(DeviceRestrictionTransformerInterface $deviceRestrictionTransformer, DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer, DeviceProfileComponentTransformerInterface $deviceProfileComponentTransformer)
    {
        $this->deviceRestrictionTransformer = $deviceRestrictionTransformer;
        $this->devicePreferenceDefinitionTransformer = $devicePreferenceDefinitionTransformer;
        $this->deviceProfileComponentTransformer = $deviceProfileComponentTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileDetailsInterface
    {
        $model = new DeviceProfileDetails();

        $this->applyRestrictions($model, $data);
        $this->applyPreferences($model, $data);
        $this->applyComponents($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyComponents(DeviceProfileDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_COMPONENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMPONENTS])) {
            return;
        }
        $model->setComponents($this->transformListDeviceProfileComponent($data[self::KEY_COMPONENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPreferences(DeviceProfileDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PREFERENCES])) {
            return;
        }
        if (!is_array($data[self::KEY_PREFERENCES])) {
            return;
        }
        $model->setPreferences($this->transformListDevicePreferenceDefinition($data[self::KEY_PREFERENCES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRestrictions(DeviceProfileDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_RESTRICTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_RESTRICTIONS])) {
            return;
        }
        $model->setRestrictions($this->deviceRestrictionTransformer->transform($data[self::KEY_RESTRICTIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    private function transformListDevicePreferenceDefinition(array $data): array
    {
        return array_values(array_map(fn (array $item): DevicePreferenceDefinitionInterface => $this->devicePreferenceDefinitionTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceProfileComponentInterface>
     */
    private function transformListDeviceProfileComponent(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceProfileComponentInterface => $this->deviceProfileComponentTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
