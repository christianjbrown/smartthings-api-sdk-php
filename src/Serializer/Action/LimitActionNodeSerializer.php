<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\LimitActionInterface;

use function array_filter;
use function array_map;

/**
 * Serializes LimitActionInterface into its JSON body.
 */
final class LimitActionNodeSerializer implements LimitActionNodeSerializerInterface
{
    /**
     * @param LimitActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_COUNT => $value->getCount(),
            self::KEY_PERIOD => $value->getPeriod(),
            self::KEY_ACTIONS => self::serializeRequiredActionList($value->getActions(), $registry),
            self::KEY_SEQUENCE => self::serializeOptionalActionSequence($value->getSequence(), $registry),
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
    private static function serializeOptionalActionSequence(?ActionSequenceInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(ActionSequenceInterface::class)->serialize($value, $registry);
    }

    /**
     * @param array<int, ActionInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private static function serializeRequiredActionList(array $values, NodeSerializerRegistryInterface $registry): array
    {
        return array_map(static fn (ActionInterface $item): array => $registry->get(ActionInterface::class)->serialize($item, $registry), $values);
    }
}
