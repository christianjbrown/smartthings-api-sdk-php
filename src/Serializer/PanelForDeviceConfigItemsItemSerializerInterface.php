<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItemInterface;

interface PanelForDeviceConfigItemsItemSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_HIDE_ON_UNMATCH = 'hideOnUnmatch';
    public const string KEY_IDX = 'idx';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_SIZE = 'size';
    public const string KEY_VALUES = 'values';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';

    /**
     * @return mixed[]
     */
    public function serialize(PanelForDeviceConfigItemsItemInterface $model): array;
}
