<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ListForArgumentInterface;

interface ListForArgumentSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';

    /**
     * @return mixed[]
     */
    public function serialize(ListForArgumentInterface $model): array;
}
