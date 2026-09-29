<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMapInterface;

interface SupportedValuesForDynamicListValueMapSerializerInterface
{
    public const string KEY_KEY = 'key';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(SupportedValuesForDynamicListValueMapInterface $model): array;
}
