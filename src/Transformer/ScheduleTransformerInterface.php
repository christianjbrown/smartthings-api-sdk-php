<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ScheduleInterface;

interface ScheduleTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_CRON];
    public const string KEY_CRON = 'cron';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_NAME = 'name';
    public const string KEY_SCHEDULED_EXECUTIONS = 'scheduledExecutions';
    public const string KEY_USER_UUID = 'userUuid';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ScheduleInterface;
}
