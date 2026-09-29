<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightInterface;

interface BasicPlusLightSerializerInterface
{
    public const string KEY_COLOR_CONTROL = 'colorControl';
    public const string KEY_COLOR_TEMPERATURE = 'colorTemperature';
    public const string KEY_DIMMER = 'dimmer';
    public const string KEY_HIDE_DASHBOARD_ACTIONS = 'hideDashboardActions';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusLightInterface $model): array;
}
