<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneAction;
use ChristianBrown\SmartThings\Model\SceneActionInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceRequestInterface;
use ChristianBrown\SmartThings\Model\SceneModeRequestInterface;
use ChristianBrown\SmartThings\Model\SceneSleepRequestInterface;

use function is_array;

/**
 * Builds SceneActionInterface from its decoded JSON.
 */
final class SceneActionNodeTransformer implements SceneActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneActionInterface
    {
        $model = new SceneAction();

        self::applyDeviceRequest($model, $data, $registry);
        self::applyModeRequest($model, $data, $registry);
        self::applySleepRequest($model, $data, $registry);
        self::applyDeviceGroupRequest($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceGroupRequest(SceneAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_DEVICE_GROUP_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_GROUP_REQUEST])) {
            return;
        }
        $model->setDeviceGroupRequest($registry->get(SceneDeviceGroupRequestInterface::class)->transform($data[self::KEY_DEVICE_GROUP_REQUEST], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceRequest(SceneAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_DEVICE_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_REQUEST])) {
            return;
        }
        $model->setDeviceRequest($registry->get(SceneDeviceRequestInterface::class)->transform($data[self::KEY_DEVICE_REQUEST], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModeRequest(SceneAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_MODE_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_MODE_REQUEST])) {
            return;
        }
        $model->setModeRequest($registry->get(SceneModeRequestInterface::class)->transform($data[self::KEY_MODE_REQUEST], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySleepRequest(SceneAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_SLEEP_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_SLEEP_REQUEST])) {
            return;
        }
        $model->setSleepRequest($registry->get(SceneSleepRequestInterface::class)->transform($data[self::KEY_SLEEP_REQUEST], $registry));
    }
}
