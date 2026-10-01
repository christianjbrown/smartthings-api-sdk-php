<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneArgumentInterface;

use function array_filter;

/**
 * Serializes SceneArgumentInterface into its JSON body.
 */
final class SceneArgumentNodeSerializer implements SceneArgumentNodeSerializerInterface
{
    /**
     * @param SceneArgumentInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_NAME => $value->getName(),
            self::KEY_SCHEMA => $value->getSchema(),
            self::KEY_VALUE => $value->getValue(),
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
