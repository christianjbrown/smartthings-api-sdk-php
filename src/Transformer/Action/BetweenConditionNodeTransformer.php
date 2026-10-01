<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\BetweenCondition;
use ChristianBrown\SmartThings\Model\BetweenConditionInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;

use function is_array;
use function is_bool;
use function is_string;

/**
 * Builds BetweenConditionInterface from its decoded JSON.
 */
final class BetweenConditionNodeTransformer implements BetweenConditionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): BetweenConditionInterface
    {
        $model = new BetweenCondition(self::requireValue($data, $registry), self::requireStart($data, $registry), self::requireEnd($data, $registry));

        self::applyAggregation($model, $data);
        self::applyChangesOnly($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAggregation(BetweenCondition $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesOnly(BetweenCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        $model->setChangesOnly($data[self::KEY_CHANGES_ONLY]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireEnd(array $data, NodeTransformerRegistryInterface $registry): ?OperandInterface
    {
        if (!isset($data[self::KEY_END])) {
            return null;
        }
        if (!is_array($data[self::KEY_END])) {
            return null;
        }

        return $registry->get(OperandInterface::class)->transform($data[self::KEY_END], $registry);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireStart(array $data, NodeTransformerRegistryInterface $registry): ?OperandInterface
    {
        if (!isset($data[self::KEY_START])) {
            return null;
        }
        if (!is_array($data[self::KEY_START])) {
            return null;
        }

        return $registry->get(OperandInterface::class)->transform($data[self::KEY_START], $registry);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data, NodeTransformerRegistryInterface $registry): ?OperandInterface
    {
        if (!isset($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return null;
        }

        return $registry->get(OperandInterface::class)->transform($data[self::KEY_VALUE], $registry);
    }
}
