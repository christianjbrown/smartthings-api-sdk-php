<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceProfileInterface;

interface DeviceProfileTransformerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_NAME = 'name';
    public const string KEY_STATUS = 'status';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileInterface;
}
