<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomationInterface;

interface DeviceConfigurationRequestAutomationTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_CONDITIONS = 'conditions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationRequestAutomationInterface;
}
