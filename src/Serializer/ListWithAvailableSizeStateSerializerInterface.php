<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ListWithAvailableSizeStateInterface;

interface ListWithAvailableSizeStateSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';

    /**
     * @return mixed[]
     */
    public function serialize(ListWithAvailableSizeStateInterface $model): array;
}
