<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;

interface VisibleConditionForColorItemTransformerInterface
{
    public const string KEY_OPERAND = 'operand';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_REFER_TO = 'referTo';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VisibleConditionForColorItemInterface;
}
