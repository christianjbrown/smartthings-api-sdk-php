<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItemInterface;

final class DeviceConfigurationIconsItemProductKeysItemSerializer implements DeviceConfigurationIconsItemProductKeysItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationIconsItemProductKeysItemInterface $model): array
    {
        return [
            self::KEY_MN_ID => $model->getMnId(),
            self::KEY_SETUP_ID => $model->getSetupId(),
        ];
    }
}
