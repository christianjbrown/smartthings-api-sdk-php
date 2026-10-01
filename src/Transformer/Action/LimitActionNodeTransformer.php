<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\LimitAction;
use ChristianBrown\SmartThings\Model\LimitActionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;

/**
 * Builds LimitActionInterface from its decoded JSON.
 */
final class LimitActionNodeTransformer implements LimitActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): LimitActionInterface
    {
        $model = new LimitAction(self::requireCount($data), self::requirePeriod($data), self::requireActions($data, $registry));

        self::applySequence($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySequence(LimitAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_SEQUENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_SEQUENCE])) {
            return;
        }
        $model->setSequence($registry->get(ActionSequenceInterface::class)->transform($data[self::KEY_SEQUENCE], $registry));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    private static function requireActions(array $data, NodeTransformerRegistryInterface $registry): array
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return [];
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return [];
        }

        return self::toActionList($data[self::KEY_ACTIONS], $registry);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCount(array $data): ?int
    {
        if (!isset($data[self::KEY_COUNT])) {
            return null;
        }
        if (!is_int($data[self::KEY_COUNT])) {
            return null;
        }

        return $data[self::KEY_COUNT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requirePeriod(array $data): ?string
    {
        if (empty($data[self::KEY_PERIOD])) {
            return null;
        }
        if (!is_string($data[self::KEY_PERIOD])) {
            return null;
        }

        return $data[self::KEY_PERIOD];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    private static function toActionList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(ActionInterface::class);

        return array_values(array_map(static fn (array $item): ActionInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
