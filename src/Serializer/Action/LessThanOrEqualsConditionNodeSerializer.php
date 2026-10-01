<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;

use function array_filter;

/**
 * Serializes LessThanOrEqualsConditionInterface into its JSON body.
 */
final class LessThanOrEqualsConditionNodeSerializer implements LessThanOrEqualsConditionNodeSerializerInterface
{
    /**
     * @param LessThanOrEqualsConditionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_LEFT => self::serializeOptionalOperand($value->getLeft(), $registry),
            self::KEY_RIGHT => self::serializeOptionalOperand($value->getRight(), $registry),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_CHANGES_ONLY => $value->getChangesOnly(),
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
     * @return null|mixed[]
     */
    private static function serializeOptionalOperand(?OperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(OperandInterface::class)->serialize($value, $registry);
    }
}
