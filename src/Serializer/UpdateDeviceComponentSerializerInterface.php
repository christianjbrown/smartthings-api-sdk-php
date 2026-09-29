<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceComponentInterface;

interface UpdateDeviceComponentSerializerInterface
{
    public const string KEY_CATEGORIES = 'categories';
    public const string KEY_ICON = 'icon';
    public const string KEY_ID = 'id';
    public const string KEY_LABEL = 'label';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateDeviceComponentInterface $model): array;
}
