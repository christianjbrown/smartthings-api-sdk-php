<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusLightInterface;

interface BasicPlusLightTransformerInterface
{
    public const string KEY_COLOR_CONTROL = 'colorControl';
    public const string KEY_COLOR_TEMPERATURE = 'colorTemperature';
    public const string KEY_DIMMER = 'dimmer';
    public const string KEY_HIDE_DASHBOARD_ACTIONS = 'hideDashboardActions';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusLightInterface;
}
