<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ButtonForTvInterface;

interface ButtonForTvSerializerInterface
{
    public const string KEY_ARGUMENT = 'argument';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(ButtonForTvInterface $model): array;
}
