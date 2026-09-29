<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;

interface DeviceConfigurationDpInfoItemTransformerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_DP_URI = 'dpUri';
    public const string KEY_OPERATING_MODE = 'operatingMode';
    public const string KEY_OS = 'os';
    public const string KEY_SERVER_DP_URI = 'serverDpUri';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationDpInfoItemInterface;
}
