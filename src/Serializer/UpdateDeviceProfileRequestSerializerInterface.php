<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceProfileRequestInterface;

interface UpdateDeviceProfileRequestSerializerInterface
{
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_METADATA = 'metadata';
    public const string KEY_PREFERENCES = 'preferences';
    public const string KEY_PRESENTATION_ID = 'presentationId';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateDeviceProfileRequestInterface $request): array;
}
