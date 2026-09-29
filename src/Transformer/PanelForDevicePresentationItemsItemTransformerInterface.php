<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PanelForDevicePresentationItemsItemInterface;

interface PanelForDevicePresentationItemsItemTransformerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_EMPTY = 'empty';
    public const string KEY_HIDE_ON_UNMATCH = 'hideOnUnmatch';
    public const string KEY_LABEL = 'label';
    public const string KEY_LIST = 'list';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_PUSH_BUTTON = 'pushButton';
    public const string KEY_SLIDER = 'slider';
    public const string KEY_STATE = 'state';
    public const string KEY_STEPPER = 'stepper';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelForDevicePresentationItemsItemInterface;
}
