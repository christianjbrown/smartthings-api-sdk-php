<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SleepActionExecutionResultInterface;

interface SleepActionExecutionResultTransformerInterface
{
    public const string KEY_RESULT = 'result';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SleepActionExecutionResultInterface;
}
