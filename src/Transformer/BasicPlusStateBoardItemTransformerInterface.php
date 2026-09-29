<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItemInterface;

interface BasicPlusStateBoardItemTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COLORS = 'colors';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_LABEL = 'label';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusStateBoardItemInterface;
}
