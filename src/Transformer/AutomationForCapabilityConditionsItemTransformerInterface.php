<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItemInterface;

interface AutomationForCapabilityConditionsItemTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_DYNAMIC_LIST = 'dynamicList';
    public const string KEY_EMPHASIS = 'emphasis';
    public const string KEY_ENUM_SLIDER = 'enumSlider';
    public const string KEY_LABEL = 'label';
    public const string KEY_LIST = 'list';
    public const string KEY_NUMBER_FIELD = 'numberField';
    public const string KEY_SLIDER = 'slider';
    public const string KEY_TEXT_FIELD = 'textField';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutomationForCapabilityConditionsItemInterface;
}
