<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraImageInterface;

interface BasicPlusCameraImageSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_VALUE = 'value';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusCameraImageInterface $model): array;
}
