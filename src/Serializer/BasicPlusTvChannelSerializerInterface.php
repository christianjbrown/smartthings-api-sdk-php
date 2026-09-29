<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvChannelInterface;

interface BasicPlusTvChannelSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_LABEL = 'label';
    public const string KEY_VALUE = 'value';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvChannelInterface $model): array;
}
