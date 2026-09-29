<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardInterface;

interface StandbyPowerSwitchForDashboardSerializerInterface
{
    public const string KEY_COMMAND = 'command';
    public const string KEY_STATE = 'state';

    /**
     * @return mixed[]
     */
    public function serialize(StandbyPowerSwitchForDashboardInterface $model): array;
}
