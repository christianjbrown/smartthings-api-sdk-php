<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\HubDriverInstallRequestInterface;

use function array_filter;

final class HubDriverInstallRequestSerializer implements HubDriverInstallRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(HubDriverInstallRequestInterface $request): array
    {
        return self::filter([
            self::KEY_CHANNEL_ID => $request->getChannelId(),
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
