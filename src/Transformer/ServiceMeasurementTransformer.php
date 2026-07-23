<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceMeasurement;
use ChristianBrown\SmartThings\Model\ServiceMeasurementInterface;

use function array_key_exists;
use function is_float;
use function is_int;
use function is_string;

final class ServiceMeasurementTransformer implements ServiceMeasurementTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceMeasurementInterface
    {
        $measurement = self::createMeasurement($data);

        self::applyUnit($measurement, $data);

        return $measurement;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(ServiceMeasurement $measurement, array $data): void
    {
        if (empty($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return;
        }
        $measurement->setUnit($data[self::KEY_UNIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function createMeasurement(array $data): ServiceMeasurement
    {
        if (!array_key_exists(self::KEY_VALUE, $data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_VALUE);
        }
        $value = $data[self::KEY_VALUE];
        if (is_int($value)) {
            return new ServiceMeasurement($value);
        }
        if (is_float($value)) {
            return new ServiceMeasurement($value);
        }
        if (is_string($value)) {
            return new ServiceMeasurement($value);
        }

        throw new UnexpectedResponseException(self::UNEXPECTED_VALUE);
    }
}
