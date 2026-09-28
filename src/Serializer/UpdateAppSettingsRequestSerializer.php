<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateAppSettingsRequestInterface;

use function array_filter;

final class UpdateAppSettingsRequestSerializer implements UpdateAppSettingsRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(UpdateAppSettingsRequestInterface $request): array
    {
        return self::filter([
            self::KEY_SETTINGS => $request->getSettings(),
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
