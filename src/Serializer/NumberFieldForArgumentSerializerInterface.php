<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\NumberFieldForArgumentInterface;

interface NumberFieldForArgumentSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_RANGE = 'range';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_UNIT = 'unit';

    /**
     * @return mixed[]
     */
    public function serialize(NumberFieldForArgumentInterface $model): array;
}
