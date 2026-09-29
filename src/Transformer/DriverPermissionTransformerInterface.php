<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DriverPermissionInterface;

interface DriverPermissionTransformerInterface
{
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverPermissionInterface;
}
