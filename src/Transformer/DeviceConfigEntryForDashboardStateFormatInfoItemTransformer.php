<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItem;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;

use function is_array;
use function is_string;
use function sprintf;

final class DeviceConfigEntryForDashboardStateFormatInfoItemTransformer implements DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface
{
    private DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer;
    private DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer;

    public function __construct(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer, DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer)
    {
        $this->deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer = $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer;
        $this->deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer = $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardStateFormatInfoItemInterface
    {
        $model = new DeviceConfigEntryForDashboardStateFormatInfoItem(self::requireKey($data), self::requireType($data));

        $this->applyRemainingTime($model, $data);
        $this->applyTime($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRemainingTime(DeviceConfigEntryForDashboardStateFormatInfoItem $model, array $data): void
    {
        if (!isset($data[self::KEY_REMAINING_TIME])) {
            return;
        }
        if (!is_array($data[self::KEY_REMAINING_TIME])) {
            return;
        }
        $model->setRemainingTime($this->deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer->transform($data[self::KEY_REMAINING_TIME]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTime(DeviceConfigEntryForDashboardStateFormatInfoItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TIME])) {
            return;
        }
        if (!is_array($data[self::KEY_TIME])) {
            return;
        }
        $model->setTime($this->deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer->transform($data[self::KEY_TIME]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireKey(array $data): string
    {
        if (empty($data[self::KEY_KEY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_KEY));
        }
        if (!is_string($data[self::KEY_KEY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_KEY));
        }

        return $data[self::KEY_KEY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireType(array $data): string
    {
        if (empty($data[self::KEY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TYPE));
        }
        if (!is_string($data[self::KEY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TYPE));
        }

        return $data[self::KEY_TYPE];
    }
}
