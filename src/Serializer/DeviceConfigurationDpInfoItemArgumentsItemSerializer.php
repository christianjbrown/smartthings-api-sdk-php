<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItemInterface;

final class DeviceConfigurationDpInfoItemArgumentsItemSerializer implements DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDpInfoItemArgumentsItemInterface $model): array
    {
        return [
            self::KEY_KEY => $model->getKey(),
            self::KEY_VALUE => $model->getValue(),
        ];
    }
}
