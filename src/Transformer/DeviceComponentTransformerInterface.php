<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceComponentInterface;

interface DeviceComponentTransformerInterface
{
    public const string KEY_CAPABILITIES = 'capabilities';
    public const string KEY_CATEGORIES = 'categories';
    public const string KEY_ID = 'id';
    public const string KEY_LABEL = 'label';
    public const string KEY_OPTIONAL = 'optional';
    public const string KEY_RESTRICTIONS = 'restrictions';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceComponentInterface;
}
