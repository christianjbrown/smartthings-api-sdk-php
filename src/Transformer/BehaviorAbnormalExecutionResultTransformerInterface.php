<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BehaviorAbnormalExecutionResultInterface;

interface BehaviorAbnormalExecutionResultTransformerInterface
{
    public const string KEY_REASON = 'reason';
    public const string KEY_RESULT = 'result';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BehaviorAbnormalExecutionResultInterface;
}
