<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\IfActionSequenceInterface;

use function array_filter;

/**
 * Serializes IfActionSequenceInterface into its JSON body.
 */
final class IfActionSequenceNodeSerializer implements IfActionSequenceNodeSerializerInterface
{
    /**
     * @param IfActionSequenceInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_THEN => $value->getThen(),
            self::KEY_ELSE => $value->getElse(),
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
}
