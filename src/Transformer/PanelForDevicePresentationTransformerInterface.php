<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PanelForDevicePresentationInterface;

interface PanelForDevicePresentationTransformerInterface
{
    public const string KEY_HIDE_DASHBOARD_ACTIONS = 'hideDashboardActions';
    public const string KEY_ITEMS = 'items';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelForDevicePresentationInterface;
}
