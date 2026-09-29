<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValueInterface;

interface AttributeValueTransformerInterface
{
    public const string KEY_ATTRIBUTE = 'attribute';
    public const string KEY_INPUT_TYPE = 'inputType';
    public const string KEY_STATIC_VALUE = 'staticValue';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeValueInterface;
}
