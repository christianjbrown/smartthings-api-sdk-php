<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TemperatureConversionsItemForDevicePresentation;
use ChristianBrown\SmartThings\Model\TemperatureConversionsItemForDevicePresentationInterface;

use function is_int;
use function is_string;
use function sprintf;

final class TemperatureConversionsItemForDevicePresentationTransformer implements TemperatureConversionsItemForDevicePresentationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TemperatureConversionsItemForDevicePresentationInterface
    {
        $model = new TemperatureConversionsItemForDevicePresentation(self::requireCapability($data), self::requireValue($data));

        self::applyVersion($model, $data);
        self::applyUnit($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(TemperatureConversionsItemForDevicePresentation $model, array $data): void
    {
        if (empty($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return;
        }
        $model->setUnit($data[self::KEY_UNIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(TemperatureConversionsItemForDevicePresentation $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): string
    {
        if (empty($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        if (!is_string($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }

        return $data[self::KEY_VALUE];
    }
}
