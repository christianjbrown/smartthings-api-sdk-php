<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneCapability;
use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneCommandInterface;

use function array_filter;
use function array_map;
use function is_array;
use function is_string;

/**
 * Builds SceneCapabilityInterface from its decoded JSON.
 */
final class SceneCapabilityNodeTransformer implements SceneCapabilityNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneCapabilityInterface
    {
        $model = new SceneCapability();

        self::applyCapabilityId($model, $data);
        self::applyStatus($model, $data);
        self::applyCommands($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCapabilityId(SceneCapability $model, array $data): void
    {
        if (empty($data[self::KEY_CAPABILITY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CAPABILITY_ID])) {
            return;
        }
        $model->setCapabilityId($data[self::KEY_CAPABILITY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommands(SceneCapability $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_COMMANDS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMANDS])) {
            return;
        }
        $model->setCommands(self::toSceneCommandMap($data[self::KEY_COMMANDS], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatus(SceneCapability $model, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $model->setStatus($data[self::KEY_STATUS]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, SceneCommandInterface>
     */
    private static function toSceneCommandMap(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(SceneCommandInterface::class);

        return array_map(static fn (array $item): SceneCommandInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...)));
    }
}
