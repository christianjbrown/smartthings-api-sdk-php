<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ScheduleRequestInterface;

interface ScheduleRequestSerializerInterface
{
    public const string KEY_CRON = 'cron';
    public const string KEY_EXPRESSION = 'expression';
    public const string KEY_NAME = 'name';
    public const string KEY_ONCE = 'once';
    public const string KEY_OVERWRITE = 'overwrite';
    public const string KEY_TIME = 'time';
    public const string KEY_TIMEZONE = 'timezone';

    /**
     * @return mixed[]
     */
    public function serialize(ScheduleRequestInterface $request): array;
}
