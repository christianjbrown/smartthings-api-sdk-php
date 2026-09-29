<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;

interface DeviceConfigurationDashboardTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_BASIC_PLUS = 'basicPlus';
    public const string KEY_GROUP_VISIBLE_CONDITIONS = 'groupVisibleConditions';
    public const string KEY_STATES = 'states';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationDashboardInterface;
}
