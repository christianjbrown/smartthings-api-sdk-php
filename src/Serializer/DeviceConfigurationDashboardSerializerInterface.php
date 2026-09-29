<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;

interface DeviceConfigurationDashboardSerializerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_BASIC_PLUS = 'basicPlus';
    public const string KEY_GROUP_VISIBLE_CONDITIONS = 'groupVisibleConditions';
    public const string KEY_STATES = 'states';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDashboardInterface $model): array;
}
