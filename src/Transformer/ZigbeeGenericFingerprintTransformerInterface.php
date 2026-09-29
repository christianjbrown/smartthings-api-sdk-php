<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ZigbeeGenericFingerprintInterface;

interface ZigbeeGenericFingerprintTransformerInterface
{
    public const string KEY_CLUSTERS = 'clusters';
    public const string KEY_DEVICE_IDENTIFIERS = 'deviceIdentifiers';
    public const string KEY_DEVICE_INTEGRATION_PROFILE_KEY = 'deviceIntegrationProfileKey';
    public const string KEY_ZIGBEE_PROFILES = 'zigbeeProfiles';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ZigbeeGenericFingerprintInterface;
}
