<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SchemaOauthCredentialsRequestInterface;

use function array_filter;

final class SchemaOauthCredentialsRequestSerializer implements SchemaOauthCredentialsRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(SchemaOauthCredentialsRequestInterface $request): array
    {
        return self::filter([
            self::KEY_ENDPOINT_APP_ID => $request->getEndpointAppId(),
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
