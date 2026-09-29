<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCapabilityReferenceInterface;

interface DeviceCapabilityReferenceTransformerInterface
{
    public const string KEY_CONFIG = 'config';
    public const string KEY_EPHEMERAL = 'ephemeral';
    public const string KEY_ID = 'id';
    public const string KEY_OPTIONAL = 'optional';
    public const string KEY_RESTRICTIONS = 'restrictions';
    public const string KEY_STATUS = 'status';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceCapabilityReferenceInterface;
}
