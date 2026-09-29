<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ActionItemInterface;

interface ActionItemSerializerInterface
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

    /**
     * @return mixed[]
     */
    public function serialize(ActionItemInterface $model): array;
}
