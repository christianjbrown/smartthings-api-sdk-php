<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneArgumentInterface;
use ChristianBrown\SmartThings\Model\SceneCommand;
use ChristianBrown\SmartThings\Model\SceneCommandInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

/**
 * Builds SceneCommandInterface from its decoded JSON.
 */
final class SceneCommandNodeTransformer implements SceneCommandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneCommandInterface
    {
        $model = new SceneCommand();

        self::applyArguments($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArguments(SceneCommand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return;
        }
        $model->setArguments(self::toSceneArgumentList($data[self::KEY_ARGUMENTS], $registry));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneArgumentInterface>
     */
    private static function toSceneArgumentList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(SceneArgumentInterface::class);

        return array_values(array_map(static fn (array $item): SceneArgumentInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
