<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ScheduleDetailsInterface;

interface ScheduleDetailsTransformerInterface
{
    public const string KEY_CRON = 'cron';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ScheduleDetailsInterface;
}
