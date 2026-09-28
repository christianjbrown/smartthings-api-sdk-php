<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\GenerateAppOauthRequestInterface;

use function array_filter;

final class GenerateAppOauthRequestSerializer implements GenerateAppOauthRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(GenerateAppOauthRequestInterface $request): array
    {
        return self::filter([
            self::KEY_CLIENT_NAME => $request->getClientName(),
            self::KEY_SCOPE => $request->getScope(),
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
