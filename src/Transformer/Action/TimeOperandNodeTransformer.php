<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\TimeOperand;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds TimeOperandInterface from its decoded JSON.
 */
final class TimeOperandNodeTransformer implements TimeOperandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): TimeOperandInterface
    {
        $model = new TimeOperand(self::requireReference($data));

        self::applyTimeZoneId($model, $data);
        self::applyDaysOfWeek($model, $data);
        self::applyOffset($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDaysOfWeek(TimeOperand $model, array $data): void
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
    private static function applyOffset(TimeOperand $model, array $data, NodeTransformerRegistryInterface $registry): void
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
    private static function applyTimeZoneId(TimeOperand $model, array $data): void
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
