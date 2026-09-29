<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColorsInterface;

interface BasicPlusStateBoardColorsSerializerInterface
{
    public const string KEY_COLOR = 'color';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusStateBoardColorsInterface $model): array;
}
