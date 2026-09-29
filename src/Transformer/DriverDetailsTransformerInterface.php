<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DriverDetailsInterface;

interface DriverDetailsTransformerInterface
{
    public const string KEY_DEVICE_INTEGRATION_PROFILES = 'deviceIntegrationProfiles';
    public const string KEY_FINGERPRINTS = 'fingerprints';
    public const string KEY_PERMISSIONS = 'permissions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverDetailsInterface;
}
