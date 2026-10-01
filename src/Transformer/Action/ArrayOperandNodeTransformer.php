<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\ArrayOperand;
use ChristianBrown\SmartThings\Model\ArrayOperandInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds ArrayOperandInterface from its decoded JSON.
 */
final class ArrayOperandNodeTransformer implements ArrayOperandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): ArrayOperandInterface
    {
        $model = new ArrayOperand(self::requireOperands($data, $registry));

        self::applyAggregation($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAggregation(ArrayOperand $model, array $data): void
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
     * @param mixed[] $data
     *
     * @return array<int, OperandInterface>
     */
    private static function requireOperands(array $data, NodeTransformerRegistryInterface $registry): array
    {
        if (!isset($data[self::KEY_OPERANDS])) {
            return [];
        }
        if (!is_array($data[self::KEY_OPERANDS])) {
            return [];
        }

        return self::toOperandList($data[self::KEY_OPERANDS], $registry);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OperandInterface>
     */
    private static function toOperandList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(OperandInterface::class);

        return array_values(array_map(static fn (array $item): OperandInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
