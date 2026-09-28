<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateAppSettingsRequestInterface;

interface UpdateAppSettingsRequestSerializerInterface
{
    public const string KEY_SETTINGS = 'settings';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateAppSettingsRequestInterface $request): array;
}
