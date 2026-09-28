<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateAppOauthRequestInterface;

use function array_filter;

final class UpdateAppOauthRequestSerializer implements UpdateAppOauthRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(UpdateAppOauthRequestInterface $request): array
    {
        return self::filter([
            self::KEY_CLIENT_NAME => $request->getClientName(),
            self::KEY_SCOPE => $request->getScope(),
            self::KEY_REDIRECT_URIS => $request->getRedirectUris(),
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
