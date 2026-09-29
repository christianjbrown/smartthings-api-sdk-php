<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;

interface BasicPlusTvVolumeCommandTransformerInterface
{
    public const string KEY_DECREASE = 'decrease';
    public const string KEY_INCREASE = 'increase';
    public const string KEY_NAME = 'name';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvVolumeCommandInterface;
}
