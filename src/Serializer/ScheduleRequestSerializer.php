<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CronScheduleInterface;
use ChristianBrown\SmartThings\Model\OnceScheduleInterface;
use ChristianBrown\SmartThings\Model\ScheduleRequestInterface;

use function array_filter;

final class ScheduleRequestSerializer implements ScheduleRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ScheduleRequestInterface $request): array
    {
        return self::filter([
            self::KEY_NAME => $request->getName(),
            self::KEY_ONCE => self::serializeOptionalOnceSchedule($request->getOnce()),
            self::KEY_CRON => self::serializeOptionalCronSchedule($request->getCron()),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCronSchedule(CronScheduleInterface $value): array
    {
        return self::filter([
            self::KEY_EXPRESSION => $value->getExpression(),
            self::KEY_TIMEZONE => $value->getTimezone(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeOnceSchedule(OnceScheduleInterface $value): array
    {
        return self::filter([
            self::KEY_TIME => $value->getTime(),
            self::KEY_OVERWRITE => $value->getOverwrite(),
        ]);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCronSchedule(?CronScheduleInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeCronSchedule($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalOnceSchedule(?OnceScheduleInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeOnceSchedule($value);
    }
}
