<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\DateOperand;
use ChristianBrown\SmartThings\Model\DateOperandInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_int;
use function is_string;

/**
 * Builds DateOperandInterface from its decoded JSON.
 */
final class DateOperandNodeTransformer implements DateOperandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): DateOperandInterface
    {
        $model = new DateOperand();

        self::applyTimeZoneId($model, $data);
        self::applyDaysOfWeek($model, $data);
        self::applyYear($model, $data);
        self::applyMonth($model, $data);
        self::applyDay($model, $data);
        self::applyReference($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDay(DateOperand $model, array $data): void
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
    private static function applyDaysOfWeek(DateOperand $model, array $data): void
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
    private static function applyMonth(DateOperand $model, array $data): void
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
    private static function applyReference(DateOperand $model, array $data): void
    {
        if (empty($data[self::KEY_REFERENCE])) {
            return;
        }
        if (!is_string($data[self::KEY_REFERENCE])) {
            return;
        }
        $model->setReference($data[self::KEY_REFERENCE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimeZoneId(DateOperand $model, array $data): void
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
    private static function applyYear(DateOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_YEAR])) {
            return;
        }
        if (!is_int($data[self::KEY_YEAR])) {
            return;
        }
        $model->setYear($data[self::KEY_YEAR]);
    }
}
