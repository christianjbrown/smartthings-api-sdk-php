<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColorInterface;

interface BasicPlusLightColorControlColorTransformerInterface
{
    public const string KEY_HUE = 'hue';
    public const string KEY_SATURATION = 'saturation';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusLightColorControlColorInterface;
}
