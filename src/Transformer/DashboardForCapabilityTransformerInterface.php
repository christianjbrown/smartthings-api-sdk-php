<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;

interface DashboardForCapabilityTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_PANEL_ITEMS = 'panelItems';
    public const string KEY_STATES = 'states';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DashboardForCapabilityInterface;
}
