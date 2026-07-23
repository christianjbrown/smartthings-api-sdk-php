<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Schedule;
use ChristianBrown\SmartThings\Model\ScheduleInterface;

use function is_string;
use function sprintf;

final class ScheduleTransformer implements ScheduleTransformerInterface
{
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

        return $schedule;
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
}
