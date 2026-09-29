<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;

interface BasicPlusItemSerializerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_CAMERA = 'camera';
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_LIGHT = 'light';
    public const string KEY_PANEL = 'panel';
    public const string KEY_PROGRESS_BARS = 'progressBars';
    public const string KEY_STATE_BOARD = 'stateBoard';
    public const string KEY_TV = 'tv';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusItemInterface $model): array;
}
