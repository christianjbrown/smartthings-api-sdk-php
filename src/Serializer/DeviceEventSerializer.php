<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceEventInterface;

use function array_filter;
use function array_map;

final class DeviceEventSerializer implements DeviceEventSerializerInterface
{
    /**
     * @param array<int, DeviceEventInterface> $events
     *
     * @return array<int, mixed[]>
     */
    public function serialize(array $events): array
    {
        return array_map(static fn (DeviceEventInterface $event): array => self::serializeOne($event), $events);
    }

    /**
     * @return mixed[]
     */
    private static function serializeOne(DeviceEventInterface $event): array
    {
        $optional = [
            self::KEY_COMPONENT => $event->getComponent(),
            self::KEY_CAPABILITY => $event->getCapability(),
            self::KEY_ATTRIBUTE => $event->getAttribute(),
            self::KEY_UNIT => $event->getUnit(),
            self::KEY_DATA => $event->getData(),
            self::KEY_COMMAND_ID => $event->getCommandId(),
        ];

        // The value is a required field, sent even when falsy (0, false, "").
        // Optional fields are omitted rather than sent as explicit nulls.
        return [self::KEY_VALUE => $event->getValue()] + array_filter($optional, static fn (mixed $value): bool => null !== $value);
    }
}
