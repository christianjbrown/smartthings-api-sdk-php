<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequest;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;

use function is_array;
use function is_string;

/**
 * Builds SceneDeviceGroupRequestInterface from its decoded JSON.
 */
final class SceneDeviceGroupRequestNodeTransformer implements SceneDeviceGroupRequestNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneDeviceGroupRequestInterface
    {
        $model = new SceneDeviceGroupRequest(self::requireDeviceGroupId($data));

        self::applyActionId($model, $data);
        self::applyCapability($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionId(SceneDeviceGroupRequest $model, array $data): void
    {
        if (empty($data[self::KEY_ACTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTION_ID])) {
            return;
        }
        $model->setActionId($data[self::KEY_ACTION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCapability(SceneDeviceGroupRequest $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_CAPABILITY])) {
            return;
        }
        if (!is_array($data[self::KEY_CAPABILITY])) {
            return;
        }
        $model->setCapability($registry->get(SceneCapabilityInterface::class)->transform($data[self::KEY_CAPABILITY], $registry));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDeviceGroupId(array $data): ?string
    {
        if (empty($data[self::KEY_DEVICE_GROUP_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_DEVICE_GROUP_ID])) {
            return null;
        }

        return $data[self::KEY_DEVICE_GROUP_ID];
    }
}
