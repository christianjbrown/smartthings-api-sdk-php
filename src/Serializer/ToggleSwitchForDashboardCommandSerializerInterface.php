<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;

interface ToggleSwitchForDashboardCommandSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_OFF = 'off';
    public const string KEY_ON = 'on';

    /**
     * @return mixed[]
     */
    public function serialize(ToggleSwitchForDashboardCommandInterface $model): array;
}
