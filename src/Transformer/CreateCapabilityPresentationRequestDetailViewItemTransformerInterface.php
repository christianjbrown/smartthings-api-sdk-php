<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;

interface CreateCapabilityPresentationRequestDetailViewItemTransformerInterface
{
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_LABEL = 'label';
    public const string KEY_LIST = 'list';
    public const string KEY_NUMBER_FIELD = 'numberField';
    public const string KEY_PLAY_PAUSE = 'playPause';
    public const string KEY_PLAY_STOP = 'playStop';
    public const string KEY_PUSH_BUTTON = 'pushButton';
    public const string KEY_SLIDER = 'slider';
    public const string KEY_STANDBY_POWER_SWITCH = 'standbyPowerSwitch';
    public const string KEY_STATE = 'state';
    public const string KEY_STEPPER = 'stepper';
    public const string KEY_SWITCH = 'switch';
    public const string KEY_TEXT_BUTTON = 'textButton';
    public const string KEY_TEXT_FIELD = 'textField';
    public const string KEY_TOGGLE_SWITCH = 'toggleSwitch';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CreateCapabilityPresentationRequestDetailViewItemInterface;
}
