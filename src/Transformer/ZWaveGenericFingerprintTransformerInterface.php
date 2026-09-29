<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZWaveGenericFingerprintInterface;

interface ZWaveGenericFingerprintTransformerInterface
{
    public const string KEY_COMMAND_CLASSES = 'commandClasses';
    public const string KEY_DEVICE_INTEGRATION_PROFILE_KEY = 'deviceIntegrationProfileKey';
    public const string KEY_GENERIC_TYPE = 'genericType';
    public const string KEY_SPECIFIC_TYPE = 'specificType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZWaveGenericFingerprintInterface;
}
