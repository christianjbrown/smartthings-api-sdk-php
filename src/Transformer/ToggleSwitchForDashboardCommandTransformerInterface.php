<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;

interface ToggleSwitchForDashboardCommandTransformerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_OFF = 'off';
    public const string KEY_ON = 'on';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ToggleSwitchForDashboardCommandInterface;
}
