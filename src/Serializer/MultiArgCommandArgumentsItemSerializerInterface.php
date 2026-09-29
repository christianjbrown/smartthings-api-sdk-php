<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItemInterface;

interface MultiArgCommandArgumentsItemSerializerInterface
{
    public const string KEY_DISPLAY_TYPE = 'displayType';
    public const string KEY_LABEL = 'label';
    public const string KEY_LIST = 'list';
    public const string KEY_NUMBER_FIELD = 'numberField';
    public const string KEY_SLIDER = 'slider';
    public const string KEY_TEXT_FIELD = 'textField';

    /**
     * @return mixed[]
     */
    public function serialize(MultiArgCommandArgumentsItemInterface $model): array;
}
