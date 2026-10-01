<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneComponent;
use ChristianBrown\SmartThings\Model\SceneComponentInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds SceneComponentInterface from its decoded JSON.
 */
final class SceneComponentNodeTransformer implements SceneComponentNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneComponentInterface
    {
        $model = new SceneComponent();

        self::applyComponentId($model, $data);
        self::applyCapabilities($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCapabilities(SceneComponent $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_CAPABILITIES])) {
            return;
        }
        if (!is_array($data[self::KEY_CAPABILITIES])) {
            return;
        }
        $model->setCapabilities(self::toSceneCapabilityList($data[self::KEY_CAPABILITIES], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponentId(SceneComponent $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT_ID])) {
            return;
        }
        $model->setComponentId($data[self::KEY_COMPONENT_ID]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneCapabilityInterface>
     */
    private static function toSceneCapabilityList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(SceneCapabilityInterface::class);

        return array_values(array_map(static fn (array $item): SceneCapabilityInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
