<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;

interface SupportedValuesForDynamicListSerializerInterface
{
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_MAP = 'valueMap';

    /**
     * @return mixed[]
     */
    public function serialize(SupportedValuesForDynamicListInterface $model): array;
}
