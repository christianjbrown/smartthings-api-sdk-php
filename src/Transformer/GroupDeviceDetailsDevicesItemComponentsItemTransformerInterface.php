<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemComponentsItemInterface;

interface GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface
{
    public const string KEY_ID = 'id';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GroupDeviceDetailsDevicesItemComponentsItemInterface;
}
