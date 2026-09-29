<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DriverFingerprint;
use ChristianBrown\SmartThings\Model\DriverFingerprintInterface;

use function is_array;
use function is_string;
use function sprintf;

final class DriverFingerprintTransformer implements DriverFingerprintTransformerInterface
{
    private ZigbeeGenericFingerprintTransformerInterface $zigbeeGenericFingerprintTransformer;
    private ZigbeeManufacturerFingerprintTransformerInterface $zigbeeManufacturerFingerprintTransformer;
    private ZWaveGenericFingerprintTransformerInterface $zWaveGenericFingerprintTransformer;
    private ZWaveManufacturerFingerprintTransformerInterface $zWaveManufacturerFingerprintTransformer;

    public function __construct(ZigbeeGenericFingerprintTransformerInterface $zigbeeGenericFingerprintTransformer, ZigbeeManufacturerFingerprintTransformerInterface $zigbeeManufacturerFingerprintTransformer, ZWaveManufacturerFingerprintTransformerInterface $zWaveManufacturerFingerprintTransformer, ZWaveGenericFingerprintTransformerInterface $zWaveGenericFingerprintTransformer)
    {
        $this->zigbeeGenericFingerprintTransformer = $zigbeeGenericFingerprintTransformer;
        $this->zigbeeManufacturerFingerprintTransformer = $zigbeeManufacturerFingerprintTransformer;
        $this->zWaveManufacturerFingerprintTransformer = $zWaveManufacturerFingerprintTransformer;
        $this->zWaveGenericFingerprintTransformer = $zWaveGenericFingerprintTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverFingerprintInterface
    {
        $model = new DriverFingerprint(self::requireId($data), self::requireType($data));

        self::applyDeviceLabel($model, $data);
        $this->applyZigbeeGeneric($model, $data);
        $this->applyZigbeeManfacturer($model, $data);
        $this->applyZwaveManufacturer($model, $data);
        $this->applyZwaveGeneric($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceLabel(DriverFingerprint $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_LABEL])) {
            return;
        }
        $model->setDeviceLabel($data[self::KEY_DEVICE_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyZigbeeGeneric(DriverFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_GENERIC])) {
            return;
        }
        if (!is_array($data[self::KEY_ZIGBEE_GENERIC])) {
            return;
        }
        $model->setZigbeeGeneric($this->zigbeeGenericFingerprintTransformer->transform($data[self::KEY_ZIGBEE_GENERIC]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyZigbeeManfacturer(DriverFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_MANFACTURER])) {
            return;
        }
        if (!is_array($data[self::KEY_ZIGBEE_MANFACTURER])) {
            return;
        }
        $model->setZigbeeManfacturer($this->zigbeeManufacturerFingerprintTransformer->transform($data[self::KEY_ZIGBEE_MANFACTURER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyZwaveGeneric(DriverFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_ZWAVE_GENERIC])) {
            return;
        }
        if (!is_array($data[self::KEY_ZWAVE_GENERIC])) {
            return;
        }
        $model->setZwaveGeneric($this->zWaveGenericFingerprintTransformer->transform($data[self::KEY_ZWAVE_GENERIC]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyZwaveManufacturer(DriverFingerprint $model, array $data): void
    {
        if (!isset($data[self::KEY_ZWAVE_MANUFACTURER])) {
            return;
        }
        if (!is_array($data[self::KEY_ZWAVE_MANUFACTURER])) {
            return;
        }
        $model->setZwaveManufacturer($this->zWaveManufacturerFingerprintTransformer->transform($data[self::KEY_ZWAVE_MANUFACTURER]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireId(array $data): string
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }

        return $data[self::KEY_ID];
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
