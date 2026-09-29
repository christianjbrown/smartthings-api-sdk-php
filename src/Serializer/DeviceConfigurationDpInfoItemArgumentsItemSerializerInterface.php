<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItemInterface;

interface DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface
{
    public const string KEY_KEY = 'key';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDpInfoItemArgumentsItemInterface $model): array;
}
