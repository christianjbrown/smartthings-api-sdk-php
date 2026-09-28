<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceRequestInterface;

use function array_filter;

final class UpdateDeviceRequestSerializer implements UpdateDeviceRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(UpdateDeviceRequestInterface $request): array
    {
        $serialized = [
            self::KEY_LABEL => $request->getLabel(),
            self::KEY_LOCATION_ID => $request->getLocationId(),
            self::KEY_ROOM_ID => $request->getRoomId(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
