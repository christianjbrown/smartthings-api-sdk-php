<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;

interface StandbyPowerSwitchForDashboardStateSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_LABEL = 'label';
    public const string KEY_OFF = 'off';
    public const string KEY_ON = 'on';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';

    /**
     * @return mixed[]
     */
    public function serialize(StandbyPowerSwitchForDashboardStateInterface $model): array;
}
