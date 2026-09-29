<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayStopCommandInterface;

interface PlayStopCommandSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_PLAY = 'play';
    public const string KEY_STOP = 'stop';

    /**
     * @return mixed[]
     */
    public function serialize(PlayStopCommandInterface $model): array;
}
