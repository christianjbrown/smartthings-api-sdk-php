<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeUnitSchemaInterface;

interface AttributeUnitSchemaTransformerInterface
{
    public const string KEY_DEFAULT = 'default';
    public const string KEY_ENUM = 'enum';
    public const string KEY_TYPE = 'type';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeUnitSchemaInterface;
}
