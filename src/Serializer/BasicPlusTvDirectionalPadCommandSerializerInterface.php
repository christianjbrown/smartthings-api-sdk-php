<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;

interface BasicPlusTvDirectionalPadCommandSerializerInterface
{
    public const string KEY_DOWN = 'down';
    public const string KEY_LEFT = 'left';
    public const string KEY_NAME = 'name';
    public const string KEY_OK = 'ok';
    public const string KEY_RIGHT = 'right';
    public const string KEY_UP = 'up';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvDirectionalPadCommandInterface $model): array;
}
