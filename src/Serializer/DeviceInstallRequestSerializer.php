<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceInstallRequestInterface;

use function array_filter;

final class DeviceInstallRequestSerializer implements DeviceInstallRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(DeviceInstallRequestInterface $request): array
    {
        $serialized = [
            self::KEY_LOCATION_ID => $request->getLocationId(),
            self::KEY_LABEL => $request->getLabel(),
            self::KEY_ROOM_ID => $request->getRoomId(),
            self::KEY_APP => self::serializeApp($request),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return mixed[]
     */
    private static function serializeApp(DeviceInstallRequestInterface $request): array
    {
        $app = $request->getApp();
        $serialized = [
            self::KEY_PROFILE_ID => $app->getProfileId(),
            self::KEY_INSTALLED_APP_ID => $app->getInstalledAppId(),
            self::KEY_EXTERNAL_ID => $app->getExternalId(),
        ];

        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
