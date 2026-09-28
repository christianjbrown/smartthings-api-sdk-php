<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\ScheduleInterface;
use ChristianBrown\SmartThings\Model\ScheduleRequestInterface;

interface ScheduleApiInterface extends ApiInterface
{
    public const string API_URL_LIST_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/schedules';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/schedules/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a schedule for an installed app. Invalidates the cached schedule list of that installed app.
     */
    public function createSchedule(string $installedAppId, ScheduleRequestInterface $request): ScheduleInterface;

    /**
     * Deletes one schedule. Invalidates its cached copy and the cached schedule list of the installed app.
     */
    public function deleteSchedule(string $installedAppId, string $scheduleName): void;

    /**
     * Deletes every schedule of an installed app. Invalidates the cached schedules of that installed app.
     */
    public function deleteSchedules(string $installedAppId): void;

    /**
     * @return array<int, ScheduleInterface>
     */
    public function getMultiple(string $installedAppId, bool $skipCache = false): array;

    public function getOneByName(string $installedAppId, string $scheduleName, bool $skipCache = false): ScheduleInterface;
}
