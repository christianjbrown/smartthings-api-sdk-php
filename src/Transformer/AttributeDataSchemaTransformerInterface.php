<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeDataSchemaInterface;

interface AttributeDataSchemaTransformerInterface
{
    public const string KEY_ADDITIONAL_PROPERTIES = 'additionalProperties';
    public const string KEY_PROPERTIES = 'properties';
    public const string KEY_REQUIRED = 'required';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeDataSchemaInterface;
}
