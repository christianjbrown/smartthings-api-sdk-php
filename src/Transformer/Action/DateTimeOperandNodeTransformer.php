<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\DateTimeOperand;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\IntervalInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_int;
use function is_string;

/**
 * Builds DateTimeOperandInterface from its decoded JSON.
 */
final class DateTimeOperandNodeTransformer implements DateTimeOperandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): DateTimeOperandInterface
    {
        $model = new DateTimeOperand(self::requireReference($data));

        self::applyTimeZoneId($model, $data);
        self::applyLocationId($model, $data);
        self::applyDaysOfWeek($model, $data);
        self::applyYear($model, $data);
        self::applyMonth($model, $data);
        self::applyDay($model, $data);
        self::applyOffset($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDay(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_DAY])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY])) {
            return;
        }
        $model->setDay($data[self::KEY_DAY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDaysOfWeek(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        if (!is_array($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        $model->setDaysOfWeek(array_values(array_filter($data[self::KEY_DAYS_OF_WEEK], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(DateTimeOperand $model, array $data): void
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
    private static function applyMonth(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_MONTH])) {
            return;
        }
        if (!is_int($data[self::KEY_MONTH])) {
            return;
        }
        $model->setMonth($data[self::KEY_MONTH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOffset(DateTimeOperand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_OFFSET])) {
            return;
        }
        if (!is_array($data[self::KEY_OFFSET])) {
            return;
        }
        $model->setOffset($registry->get(IntervalInterface::class)->transform($data[self::KEY_OFFSET], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimeZoneId(DateTimeOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        $model->setTimeZoneId($data[self::KEY_TIME_ZONE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyYear(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_YEAR])) {
            return;
        }
        if (!is_int($data[self::KEY_YEAR])) {
            return;
        }
        $model->setYear($data[self::KEY_YEAR]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireReference(array $data): ?string
    {
        if (empty($data[self::KEY_REFERENCE])) {
            return null;
        }
        if (!is_string($data[self::KEY_REFERENCE])) {
            return null;
        }

        return $data[self::KEY_REFERENCE];
    }
}
