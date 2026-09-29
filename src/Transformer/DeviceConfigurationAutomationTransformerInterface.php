<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomationInterface;

interface DeviceConfigurationAutomationTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_CONDITIONS = 'conditions';
    public const string KEY_DESCRIPTIONS = 'descriptions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationAutomationInterface;
}
