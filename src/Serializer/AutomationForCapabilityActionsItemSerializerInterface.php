<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItemInterface;

interface AutomationForCapabilityActionsItemSerializerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_DYNAMIC_LIST = 'dynamicList';
    public const string KEY_EMPHASIS = 'emphasis';
    public const string KEY_LABEL = 'label';
    public const string KEY_LIST = 'list';
    public const string KEY_MULTI_ARG_COMMAND = 'multiArgCommand';
    public const string KEY_NUMBER_FIELD = 'numberField';
    public const string KEY_SLIDER = 'slider';
    public const string KEY_TEXT_FIELD = 'textField';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';

    /**
     * @return mixed[]
     */
    public function serialize(AutomationForCapabilityActionsItemInterface $model): array;
}
