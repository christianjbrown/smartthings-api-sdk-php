<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlInterface;

interface BasicPlusLightColorControlSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COLOR = 'color';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_VALUE = 'value';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusLightColorControlInterface $model): array;
}
