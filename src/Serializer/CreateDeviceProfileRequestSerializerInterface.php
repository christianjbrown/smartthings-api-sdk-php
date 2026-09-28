<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequestInterface;

interface CreateDeviceProfileRequestSerializerInterface
{
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_DEVICE_CONFIG = 'deviceConfig';
    public const string KEY_METADATA = 'metadata';
    public const string KEY_NAME = 'name';
    public const string KEY_PREFERENCES = 'preferences';
    public const string KEY_PRESENTATION_ID = 'presentationId';

    /**
     * @return mixed[]
     */
    public function serialize(CreateDeviceProfileRequestInterface $request): array;
}
