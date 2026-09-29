<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;

interface PanelItemForCapabilityTransformerInterface
{
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_EMPTY = 'empty';
    public const string KEY_LABEL = 'label';
    public const string KEY_LIST = 'list';
    public const string KEY_PUSH_BUTTON = 'pushButton';
    public const string KEY_SLIDER = 'slider';
    public const string KEY_STATE = 'state';
    public const string KEY_STEPPER = 'stepper';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelItemForCapabilityInterface;
}
