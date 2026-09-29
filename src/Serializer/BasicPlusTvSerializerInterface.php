<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvInterface;

interface BasicPlusTvSerializerInterface
{
    public const string KEY_BUTTONS = 'buttons';
    public const string KEY_CHANNEL = 'channel';
    public const string KEY_DIRECTIONAL_PAD = 'directionalPad';
    public const string KEY_HIDE_DASHBOARD_ACTIONS = 'hideDashboardActions';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';
    public const string KEY_VOLUME = 'volume';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvInterface $model): array;
}
