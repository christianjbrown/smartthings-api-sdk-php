<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeStateInterface;
use ChristianBrown\SmartThings\Model\DeviceCapabilityReference;
use ChristianBrown\SmartThings\Model\DeviceCapabilityReferenceInterface;

use function array_filter;
use function array_map;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class DeviceCapabilityReferenceTransformer implements DeviceCapabilityReferenceTransformerInterface
{
    private AttributeStateTransformerInterface $attributeStateTransformer;
    private CapabilityConfigurationTransformerInterface $capabilityConfigurationTransformer;
    private RestrictionTransformerInterface $restrictionTransformer;

    public function __construct(CapabilityConfigurationTransformerInterface $capabilityConfigurationTransformer, RestrictionTransformerInterface $restrictionTransformer, AttributeStateTransformerInterface $attributeStateTransformer)
    {
        $this->capabilityConfigurationTransformer = $capabilityConfigurationTransformer;
        $this->restrictionTransformer = $restrictionTransformer;
        $this->attributeStateTransformer = $attributeStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceCapabilityReferenceInterface
    {
        $model = new DeviceCapabilityReference(self::requireId($data));

        self::applyVersion($model, $data);
        self::applyOptional($model, $data);
        $this->applyConfig($model, $data);
        $this->applyRestrictions($model, $data);
        self::applyEphemeral($model, $data);
        $this->applyStatus($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConfig(DeviceCapabilityReference $model, array $data): void
    {
        if (!isset($data[self::KEY_CONFIG])) {
            return;
        }
        if (!is_array($data[self::KEY_CONFIG])) {
            return;
        }
        $model->setConfig($this->capabilityConfigurationTransformer->transform($data[self::KEY_CONFIG]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEphemeral(DeviceCapabilityReference $model, array $data): void
    {
        if (!isset($data[self::KEY_EPHEMERAL])) {
            return;
        }
        if (!is_bool($data[self::KEY_EPHEMERAL])) {
            return;
        }
        $model->setEphemeral($data[self::KEY_EPHEMERAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOptional(DeviceCapabilityReference $model, array $data): void
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
    private function applyRestrictions(DeviceCapabilityReference $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private function applyStatus(DeviceCapabilityReference $model, array $data): void
    {
        if (!isset($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_array($data[self::KEY_STATUS])) {
            return;
        }
        $model->setStatus($this->transformMapAttributeState($data[self::KEY_STATUS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(DeviceCapabilityReference $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
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
     * @return array<array-key, AttributeStateInterface>
     */
    private function transformMapAttributeState(array $data): array
    {
        return array_map(fn (array $item): AttributeStateInterface => $this->attributeStateTransformer->transform($item), array_filter($data, is_array(...)));
    }
}
