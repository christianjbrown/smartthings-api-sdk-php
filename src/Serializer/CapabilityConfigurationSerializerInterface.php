<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationInterface;

interface CapabilityConfigurationSerializerInterface
{
    public const string KEY_VALUES = 'values';

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityConfigurationInterface $model): array;
}
