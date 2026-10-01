<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\EveryAction;
use ChristianBrown\SmartThings\Model\EveryActionInterface;
use ChristianBrown\SmartThings\Model\IntervalInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

/**
 * Builds EveryActionInterface from its decoded JSON.
 */
final class EveryActionNodeTransformer implements EveryActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): EveryActionInterface
    {
        $model = new EveryAction(self::requireActions($data, $registry));

        self::applyInterval($model, $data, $registry);
        self::applySpecific($model, $data, $registry);
        self::applySequence($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInterval(EveryAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_INTERVAL])) {
            return;
        }
        if (!is_array($data[self::KEY_INTERVAL])) {
            return;
        }
        $model->setInterval($registry->get(IntervalInterface::class)->transform($data[self::KEY_INTERVAL], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySequence(EveryAction $model, array $data, NodeTransformerRegistryInterface $registry): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applySpecific(EveryAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_SPECIFIC])) {
            return;
        }
        if (!is_array($data[self::KEY_SPECIFIC])) {
            return;
        }
        $model->setSpecific($registry->get(DateTimeOperandInterface::class)->transform($data[self::KEY_SPECIFIC], $registry));
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
     *
     * @return array<int, ActionInterface>
     */
    private static function toActionList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(ActionInterface::class);

        return array_values(array_map(static fn (array $item): ActionInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
