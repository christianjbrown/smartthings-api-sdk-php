<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;

interface BasicPlusItemProgressBarsItemTransformerInterface
{
    public const string KEY_BAR = 'bar';
    public const string KEY_FOOTERS = 'footers';
    public const string KEY_HEADERS = 'headers';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusItemProgressBarsItemInterface;
}
