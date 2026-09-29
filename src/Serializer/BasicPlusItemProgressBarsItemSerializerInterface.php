<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;

interface BasicPlusItemProgressBarsItemSerializerInterface
{
    public const string KEY_BAR = 'bar';
    public const string KEY_FOOTERS = 'footers';
    public const string KEY_HEADERS = 'headers';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusItemProgressBarsItemInterface $model): array;
}
