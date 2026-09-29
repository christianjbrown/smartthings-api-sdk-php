<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomationInterface;

interface DeviceConfigurationAutomationSerializerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_CONDITIONS = 'conditions';
    public const string KEY_DESCRIPTIONS = 'descriptions';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationAutomationInterface $model): array;
}
