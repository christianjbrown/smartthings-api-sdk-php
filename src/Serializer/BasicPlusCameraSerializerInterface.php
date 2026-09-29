<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraInterface;

interface BasicPlusCameraSerializerInterface
{
    public const string KEY_IMAGE = 'image';
    public const string KEY_OVERLAY_ICONS = 'overlayIcons';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusCameraInterface $model): array;
}
