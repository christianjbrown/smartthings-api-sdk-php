<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\ArrayOperandInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;

use function array_filter;
use function array_map;

/**
 * Serializes ArrayOperandInterface into its JSON body.
 */
final class ArrayOperandNodeSerializer implements ArrayOperandNodeSerializerInterface
{
    /**
     * @param ArrayOperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_OPERANDS => self::serializeRequiredOperandList($value->getOperands(), $registry),
            self::KEY_AGGREGATION => $value->getAggregation(),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, OperandInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private static function serializeRequiredOperandList(array $values, NodeSerializerRegistryInterface $registry): array
    {
        return array_map(static fn (OperandInterface $item): array => $registry->get(OperandInterface::class)->serialize($item, $registry), $values);
    }
}
