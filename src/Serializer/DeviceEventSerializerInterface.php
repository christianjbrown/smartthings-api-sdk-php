<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceEventInterface;

interface DeviceEventSerializerInterface
{
    public const string KEY_ATTRIBUTE = 'attribute';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND_ID = 'commandId';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_DATA = 'data';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';

    /**
     * @param array<int, DeviceEventInterface> $events
     *
     * @return array<int, mixed[]>
     */
    public function serialize(array $events): array;
}
