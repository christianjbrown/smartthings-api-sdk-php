<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneComponentInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceRequest;
use ChristianBrown\SmartThings\Model\SceneDeviceRequestInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds SceneDeviceRequestInterface from its decoded JSON.
 */
final class SceneDeviceRequestNodeTransformer implements SceneDeviceRequestNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneDeviceRequestInterface
    {
        $model = new SceneDeviceRequest();

        self::applyDeviceId($model, $data);
        self::applyActionId($model, $data);
        self::applyComponents($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionId(SceneDeviceRequest $model, array $data): void
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
    private static function applyComponents(SceneDeviceRequest $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_COMPONENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMPONENTS])) {
            return;
        }
        $model->setComponents(self::toSceneComponentList($data[self::KEY_COMPONENTS], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceId(SceneDeviceRequest $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            return;
        }
        $model->setDeviceId($data[self::KEY_DEVICE_ID]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneComponentInterface>
     */
    private static function toSceneComponentList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(SceneComponentInterface::class);

        return array_values(array_map(static fn (array $item): SceneComponentInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
