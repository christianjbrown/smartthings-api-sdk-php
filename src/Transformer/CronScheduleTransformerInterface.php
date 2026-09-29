<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CronScheduleInterface;

interface CronScheduleTransformerInterface
{
    public const string KEY_EXPRESSION = 'expression';
    public const string KEY_TIMEZONE = 'timezone';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CronScheduleInterface;
}
