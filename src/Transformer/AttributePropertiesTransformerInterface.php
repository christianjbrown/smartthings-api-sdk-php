<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributePropertiesInterface;

interface AttributePropertiesTransformerInterface
{
    public const string KEY_DATA = 'data';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributePropertiesInterface;
}
