<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PanelForDeviceConfigInterface;

interface PanelForDeviceConfigSerializerInterface
{
    public const string KEY_HIDE_DASHBOARD_ACTIONS = 'hideDashboardActions';
    public const string KEY_ITEMS = 'items';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';

    /**
     * @return mixed[]
     */
    public function serialize(PanelForDeviceConfigInterface $model): array;
}
