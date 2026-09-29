<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceProfileDetailsInterface;

interface DeviceProfileDetailsTransformerInterface
{
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_PREFERENCES = 'preferences';
    public const string KEY_RESTRICTIONS = 'restrictions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileDetailsInterface;
}
