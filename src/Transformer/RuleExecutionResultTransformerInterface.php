<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\RuleExecutionResultInterface;

interface RuleExecutionResultTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_EXECUTION_ID = 'executionId';
    public const string KEY_ID = 'id';
    public const string KEY_RESULT = 'result';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RuleExecutionResultInterface;
}
