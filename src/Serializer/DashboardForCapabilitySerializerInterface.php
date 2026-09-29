<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;

interface DashboardForCapabilitySerializerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_PANEL_ITEMS = 'panelItems';
    public const string KEY_STATES = 'states';

    /**
     * @return mixed[]
     */
    public function serialize(DashboardForCapabilityInterface $model): array;
}
