<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CronSchedule;
use ChristianBrown\SmartThings\Model\CronScheduleInterface;

use function is_string;
use function sprintf;

final class CronScheduleTransformer implements CronScheduleTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CronScheduleInterface
    {
        $model = new CronSchedule(self::requireExpression($data), self::requireTimezone($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireExpression(array $data): string
    {
        if (empty($data[self::KEY_EXPRESSION])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_EXPRESSION));
        }
        if (!is_string($data[self::KEY_EXPRESSION])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_EXPRESSION));
        }

        return $data[self::KEY_EXPRESSION];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireTimezone(array $data): string
    {
        if (empty($data[self::KEY_TIMEZONE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIMEZONE));
        }
        if (!is_string($data[self::KEY_TIMEZONE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIMEZONE));
        }

        return $data[self::KEY_TIMEZONE];
    }
}
