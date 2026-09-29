<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayPauseCommandInterface;

interface PlayPauseCommandSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_PAUSE = 'pause';
    public const string KEY_PLAY = 'play';

    /**
     * @return mixed[]
     */
    public function serialize(PlayPauseCommandInterface $model): array;
}
