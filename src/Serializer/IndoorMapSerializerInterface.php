<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\IndoorMapInterface;

interface IndoorMapSerializerInterface
{
    public const string KEY_COORDINATES = 'coordinates';
    public const string KEY_DATA = 'data';
    public const string KEY_ROTATION = 'rotation';
    public const string KEY_VISIBLE = 'visible';

    /**
     * @return mixed[]
     */
    public function serialize(IndoorMapInterface $model): array;
}
