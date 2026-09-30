<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCapabilityReferenceInterface;
use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileComponent;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;

final class DeviceProfileComponentTransformer implements DeviceProfileComponentTransformerInterface
{
    private DeviceCapabilityReferenceTransformerInterface $deviceCapabilityReferenceTransformer;
    private DeviceCategoryTransformerInterface $deviceCategoryTransformer;
    private RestrictionTransformerInterface $restrictionTransformer;

    public function __construct(DeviceCapabilityReferenceTransformerInterface $deviceCapabilityReferenceTransformer, DeviceCategoryTransformerInterface $deviceCategoryTransformer, RestrictionTransformerInterface $restrictionTransformer)
    {
        $this->deviceCapabilityReferenceTransformer = $deviceCapabilityReferenceTransformer;
        $this->deviceCategoryTransformer = $deviceCategoryTransformer;
        $this->restrictionTransformer = $restrictionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileComponentInterface
    {
        $model = new DeviceProfileComponent(self::requireId($data), $this->requireCapabilities($data), $this->requireCategories($data));

        self::applyLabel($model, $data);
        $this->applyRestrictions($model, $data);
        self::applyOptional($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(DeviceProfileComponent $model, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $model->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOptional(DeviceProfileComponent $model, array $data): void
    {
        if (!isset($data[self::KEY_OPTIONAL])) {
            return;
        }
        if (!is_bool($data[self::KEY_OPTIONAL])) {
            return;
        }
        $model->setOptional($data[self::KEY_OPTIONAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRestrictions(DeviceProfileComponent $model, array $data): void
    {
        if (!isset($data[self::KEY_RESTRICTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_RESTRICTIONS])) {
            return;
        }
        $model->setRestrictions($this->restrictionTransformer->transform($data[self::KEY_RESTRICTIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceCapabilityReferenceInterface>
     */
    private function requireCapabilities(array $data): array
    {
        if (!isset($data[self::KEY_CAPABILITIES])) {
            return [];
        }
        if (!is_array($data[self::KEY_CAPABILITIES])) {
            return [];
        }

        return $this->transformListDeviceCapabilityReference($data[self::KEY_CAPABILITIES]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceCategoryInterface>
     */
    private function requireCategories(array $data): array
    {
        if (!isset($data[self::KEY_CATEGORIES])) {
            return [];
        }
        if (!is_array($data[self::KEY_CATEGORIES])) {
            return [];
        }

        return $this->transformListDeviceCategory($data[self::KEY_CATEGORIES]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireId(array $data): ?string
    {
        if (empty($data[self::KEY_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_ID])) {
            return null;
        }

        return $data[self::KEY_ID];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceCapabilityReferenceInterface>
     */
    private function transformListDeviceCapabilityReference(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceCapabilityReferenceInterface => $this->deviceCapabilityReferenceTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceCategoryInterface>
     */
    private function transformListDeviceCategory(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceCategoryInterface => $this->deviceCategoryTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
