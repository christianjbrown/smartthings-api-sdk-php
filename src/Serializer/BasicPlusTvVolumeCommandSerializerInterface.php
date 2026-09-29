<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;

interface BasicPlusTvVolumeCommandSerializerInterface
{
    public const string KEY_DECREASE = 'decrease';
    public const string KEY_INCREASE = 'increase';
    public const string KEY_NAME = 'name';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvVolumeCommandInterface $model): array;
}
