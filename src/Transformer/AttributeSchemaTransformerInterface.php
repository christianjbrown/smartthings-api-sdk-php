<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeSchemaInterface;

interface AttributeSchemaTransformerInterface
{
    public const string KEY_ADDITIONAL_PROPERTIES = 'additionalProperties';
    public const string KEY_PROPERTIES = 'properties';
    public const string KEY_REQUIRED = 'required';
    public const string KEY_SENSITIVE = 'sensitive';
    public const string KEY_TITLE = 'title';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeSchemaInterface;
}
