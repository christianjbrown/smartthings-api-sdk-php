<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItemInterface;

interface BasicPlusItemActionsItemTransformerInterface
{
    public const string KEY_ARGUMENT = 'argument';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusItemActionsItemInterface;
}
