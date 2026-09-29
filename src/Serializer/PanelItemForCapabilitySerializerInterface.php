<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;

interface PanelItemForCapabilitySerializerInterface
{
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_EMPTY = 'empty';
    public const string KEY_LABEL = 'label';
    public const string KEY_LIST = 'list';
    public const string KEY_PUSH_BUTTON = 'pushButton';
    public const string KEY_SLIDER = 'slider';
    public const string KEY_STATE = 'state';
    public const string KEY_STEPPER = 'stepper';

    /**
     * @return mixed[]
     */
    public function serialize(PanelItemForCapabilityInterface $model): array;
}
