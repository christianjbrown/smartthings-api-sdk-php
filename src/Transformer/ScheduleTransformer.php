<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Schedule;
use ChristianBrown\SmartThings\Model\ScheduleDetailsInterface;
use ChristianBrown\SmartThings\Model\ScheduleInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_values;
use function is_array;
use function is_int;
use function is_string;
use function sprintf;

final class ScheduleTransformer implements ScheduleTransformerInterface
{
    private ScheduleDetailsTransformerInterface $scheduleDetailsTransformer;

    public function __construct(ScheduleDetailsTransformerInterface $scheduleDetailsTransformer)
    {
        $this->scheduleDetailsTransformer = $scheduleDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ScheduleInterface
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        $schedule = new Schedule($data[self::KEY_NAME]);

        self::applyInstalledAppId($schedule, $data);

        self::applyLocationId($schedule, $data);
        self::applyUserUuid($schedule, $data);
        self::applyScheduledExecutions($schedule, $data);

        $this->applyDetails($schedule, $data);

        return $schedule;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(Schedule $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->scheduleDetailsTransformer->transform($data);
        self::copyCron($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppId(Schedule $schedule, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        $schedule->setInstalledAppId($data[self::KEY_INSTALLED_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(Schedule $model, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $model->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyScheduledExecutions(Schedule $model, array $data): void
    {
        if (!isset($data[self::KEY_SCHEDULED_EXECUTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_SCHEDULED_EXECUTIONS])) {
            return;
        }
        $model->setScheduledExecutions(array_values(array_filter($data[self::KEY_SCHEDULED_EXECUTIONS], is_int(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUserUuid(Schedule $model, array $data): void
    {
        if (empty($data[self::KEY_USER_UUID])) {
            return;
        }
        if (!is_string($data[self::KEY_USER_UUID])) {
            return;
        }
        $model->setUserUuid($data[self::KEY_USER_UUID]);
    }

    private static function copyCron(Schedule $model, ScheduleDetailsInterface $details): void
    {
        $model->setCron($details->getCron());
    }
}
