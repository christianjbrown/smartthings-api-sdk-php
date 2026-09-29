<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeStateInterface;

interface AttributeStateTransformerInterface
{
    public const string KEY_DATA = 'data';
    public const string KEY_TIMESTAMP = 'timestamp';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeStateInterface;
}
