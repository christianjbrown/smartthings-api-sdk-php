<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceProfileComponentRequestInterface;

interface DeviceProfileComponentRequestSerializerInterface
{
    public const string KEY_CAPABILITIES = 'capabilities';
    public const string KEY_CATEGORIES = 'categories';
    public const string KEY_ID = 'id';
    public const string KEY_LABEL = 'label';
    public const string KEY_OPTIONAL = 'optional';
    public const string KEY_RESTRICTIONS = 'restrictions';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceProfileComponentRequestInterface $model): array;
}
