<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColorInterface;

interface BasicPlusLightColorControlColorSerializerInterface
{
    public const string KEY_HUE = 'hue';
    public const string KEY_SATURATION = 'saturation';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusLightColorControlColorInterface $model): array;
}
