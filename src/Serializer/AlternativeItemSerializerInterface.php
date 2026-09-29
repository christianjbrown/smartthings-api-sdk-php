<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;

interface AlternativeItemSerializerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_KEY = 'key';
    public const string KEY_TYPE = 'type';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(AlternativeItemInterface $model): array;
}
