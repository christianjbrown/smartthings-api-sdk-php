<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValueSchemaInterface;

interface AttributeValueSchemaTransformerInterface
{
    public const string KEY_ADDITIONAL_KEYWORDS = 'additionalKeywords';
    public const string KEY_ENUM = 'enum';
    public const string KEY_TYPE = 'type';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeValueSchemaInterface;
}
