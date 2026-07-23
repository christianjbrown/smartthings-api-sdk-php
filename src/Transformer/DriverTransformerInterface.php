<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DriverInterface;

interface DriverTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_NAME = 'name';
    public const string KEY_PACKAGE_KEY = 'packageKey';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverInterface;
}
