<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItemInterface;

interface BasicPlusCameraOverlayIconsItemSerializerInterface
{
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusCameraOverlayIconsItemInterface $model): array;
}
