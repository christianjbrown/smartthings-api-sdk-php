<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ViperDeviceDetailsInterface;

interface ViperDeviceDetailsTransformerInterface
{
    public const string KEY_ENDPOINT_APP_ID = 'endpointAppId';
    public const string KEY_HW_VERSION = 'hwVersion';
    public const string KEY_MANUFACTURER_NAME = 'manufacturerName';
    public const string KEY_MODEL_NAME = 'modelName';
    public const string KEY_SW_VERSION = 'swVersion';
    public const string KEY_UNIQUE_IDENTIFIER = 'uniqueIdentifier';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ViperDeviceDetailsInterface;
}
