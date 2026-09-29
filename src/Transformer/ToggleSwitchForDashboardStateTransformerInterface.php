<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardStateInterface;

interface ToggleSwitchForDashboardStateTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_OFF = 'off';
    public const string KEY_ON = 'on';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ToggleSwitchForDashboardStateInterface;
}
