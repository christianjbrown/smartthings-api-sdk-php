<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\BetweenConditionInterface;
use ChristianBrown\SmartThings\Model\ChangesCondition;
use ChristianBrown\SmartThings\Model\ChangesConditionInterface;
use ChristianBrown\SmartThings\Model\ConditionInterface;
use ChristianBrown\SmartThings\Model\EqualsConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\LessThanConditionInterface;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds ChangesConditionInterface from its decoded JSON.
 */
final class ChangesConditionNodeTransformer implements ChangesConditionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): ChangesConditionInterface
    {
        $model = new ChangesCondition(self::requireId($data));

        self::applyAnd($model, $data, $registry);
        self::applyOr($model, $data, $registry);
        self::applyNot($model, $data, $registry);
        self::applyEquals($model, $data, $registry);
        self::applyGreaterThan($model, $data, $registry);
        self::applyGreaterThanOrEquals($model, $data, $registry);
        self::applyLessThan($model, $data, $registry);
        self::applyLessThanOrEquals($model, $data, $registry);
        self::applyBetween($model, $data, $registry);
        self::applyOperand($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAnd(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_AND])) {
            return;
        }
        if (!is_array($data[self::KEY_AND])) {
            return;
        }
        $model->setAnd(self::toConditionList($data[self::KEY_AND], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBetween(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_BETWEEN])) {
            return;
        }
        if (!is_array($data[self::KEY_BETWEEN])) {
            return;
        }
        $model->setBetween($registry->get(BetweenConditionInterface::class)->transform($data[self::KEY_BETWEEN], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEquals(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_EQUALS])) {
            return;
        }
        $model->setEquals($registry->get(EqualsConditionInterface::class)->transform($data[self::KEY_EQUALS], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGreaterThan(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_GREATER_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN])) {
            return;
        }
        $model->setGreaterThan($registry->get(GreaterThanConditionInterface::class)->transform($data[self::KEY_GREATER_THAN], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGreaterThanOrEquals(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        $model->setGreaterThanOrEquals($registry->get(GreaterThanOrEqualsConditionInterface::class)->transform($data[self::KEY_GREATER_THAN_OR_EQUALS], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLessThan(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_LESS_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN])) {
            return;
        }
        $model->setLessThan($registry->get(LessThanConditionInterface::class)->transform($data[self::KEY_LESS_THAN], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLessThanOrEquals(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        $model->setLessThanOrEquals($registry->get(LessThanOrEqualsConditionInterface::class)->transform($data[self::KEY_LESS_THAN_OR_EQUALS], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNot(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_NOT])) {
            return;
        }
        if (!is_array($data[self::KEY_NOT])) {
            return;
        }
        $model->setNot($registry->get(ConditionInterface::class)->transform($data[self::KEY_NOT], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperand(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_OPERAND])) {
            return;
        }
        if (!is_array($data[self::KEY_OPERAND])) {
            return;
        }
        $model->setOperand($registry->get(OperandInterface::class)->transform($data[self::KEY_OPERAND], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOr(ChangesCondition $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_OR])) {
            return;
        }
        if (!is_array($data[self::KEY_OR])) {
            return;
        }
        $model->setOr(self::toConditionList($data[self::KEY_OR], $registry));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireId(array $data): ?string
    {
        if (empty($data[self::KEY_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_ID])) {
            return null;
        }

        return $data[self::KEY_ID];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ConditionInterface>
     */
    private static function toConditionList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(ConditionInterface::class);

        return array_values(array_map(static fn (array $item): ConditionInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
