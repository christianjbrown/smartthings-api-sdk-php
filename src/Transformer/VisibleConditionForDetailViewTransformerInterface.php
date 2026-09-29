<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionForDetailViewInterface;

interface VisibleConditionForDetailViewTransformerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_HIDE_ON_UNMATCH = 'hideOnUnmatch';
    public const string KEY_OPERAND = 'operand';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VisibleConditionForDetailViewInterface;
}
