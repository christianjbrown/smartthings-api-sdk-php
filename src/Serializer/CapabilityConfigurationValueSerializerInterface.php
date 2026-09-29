<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;

interface CapabilityConfigurationValueSerializerInterface
{
    public const string KEY_ENABLED_VALUES = 'enabledValues';
    public const string KEY_KEY = 'key';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityConfigurationValueInterface $model): array;
}
