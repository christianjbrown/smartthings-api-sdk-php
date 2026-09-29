<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityReferenceRequestInterface;

interface CapabilityReferenceRequestSerializerInterface
{
    public const string KEY_CONFIG = 'config';
    public const string KEY_ID = 'id';
    public const string KEY_OPTIONAL = 'optional';
    public const string KEY_RESTRICTIONS = 'restrictions';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityReferenceRequestInterface $model): array;
}
