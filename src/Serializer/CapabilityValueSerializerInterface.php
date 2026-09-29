<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;

interface CapabilityValueSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_ENABLED_VALUES = 'enabledValues';
    public const string KEY_KEY = 'key';
    public const string KEY_LABEL = 'label';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityValueInterface $model): array;
}
