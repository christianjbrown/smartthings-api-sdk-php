<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\LessThanOrEqualsCondition;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;

use function is_array;
use function is_bool;
use function is_string;

/**
 * Builds LessThanOrEqualsConditionInterface from its decoded JSON.
 */
final class LessThanOrEqualsConditionNodeTransformer implements LessThanOrEqualsConditionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): LessThanOrEqualsConditionInterface
    {
        $model = new LessThanOrEqualsCondition(self::requireLeft($data, $registry), self::requireRight($data, $registry));

        self::applyAggregation($model, $data);
        self::applyChangesOnly($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAggregation(LessThanOrEqualsCondition $model, array $data): void
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
    private static function applyChangesOnly(LessThanOrEqualsCondition $model, array $data): void
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
    private static function requireLeft(array $data, NodeTransformerRegistryInterface $registry): ?OperandInterface
    {
        if (!isset($data[self::KEY_LEFT])) {
            return null;
        }
        if (!is_array($data[self::KEY_LEFT])) {
            return null;
        }

        return $registry->get(OperandInterface::class)->transform($data[self::KEY_LEFT], $registry);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireRight(array $data, NodeTransformerRegistryInterface $registry): ?OperandInterface
    {
        if (!isset($data[self::KEY_RIGHT])) {
            return null;
        }
        if (!is_array($data[self::KEY_RIGHT])) {
            return null;
        }

        return $registry->get(OperandInterface::class)->transform($data[self::KEY_RIGHT], $registry);
    }
}
