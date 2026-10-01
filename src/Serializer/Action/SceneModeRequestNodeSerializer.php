<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneModeRequestInterface;

use function array_filter;

/**
 * Serializes SceneModeRequestInterface into its JSON body.
 */
final class SceneModeRequestNodeSerializer implements SceneModeRequestNodeSerializerInterface
{
    /**
     * @param SceneModeRequestInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_MODE_ID => $value->getModeId(),
            self::KEY_ACTION_ID => $value->getActionId(),
            self::KEY_MODE_NAME => $value->getModeName(),
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
