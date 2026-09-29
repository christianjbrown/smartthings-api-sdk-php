<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteRequestInterface;

use function array_filter;

final class SchemaAppInviteRequestSerializer implements SchemaAppInviteRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(SchemaAppInviteRequestInterface $request): array
    {
        return self::filter([
            self::KEY_SCHEMA_APP_ID => $request->getSchemaAppId(),
            self::KEY_DESCRIPTION => $request->getDescription(),
            self::KEY_ACCEPT_LIMIT => $request->getAcceptLimit(),
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
