<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;

interface BasicPlusItemTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_CAMERA = 'camera';
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_LIGHT = 'light';
    public const string KEY_PANEL = 'panel';
    public const string KEY_PROGRESS_BARS = 'progressBars';
    public const string KEY_STATE_BOARD = 'stateBoard';
    public const string KEY_TV = 'tv';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusItemInterface;
}
