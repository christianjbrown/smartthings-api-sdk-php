<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionItemInterface;

interface ActionItemTransformerInterface
{
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_GROUP = 'group';
    public const string KEY_PLAY_PAUSE = 'playPause';
    public const string KEY_PLAY_STOP = 'playStop';
    public const string KEY_PUSH_BUTTON = 'pushButton';
    public const string KEY_STANDBY_POWER_SWITCH = 'standbyPowerSwitch';
    public const string KEY_STATELESS_POWER_TOGGLE = 'statelessPowerToggle';
    public const string KEY_SWITCH = 'switch';
    public const string KEY_TOGGLE_SWITCH = 'toggleSwitch';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionItemInterface;
}
