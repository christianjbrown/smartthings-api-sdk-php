<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DriverFingerprintInterface;

interface DriverFingerprintTransformerInterface
{
    public const string KEY_DEVICE_LABEL = 'deviceLabel';
    public const string KEY_ID = 'id';
    public const string KEY_TYPE = 'type';
    public const string KEY_ZIGBEE_GENERIC = 'zigbeeGeneric';
    public const string KEY_ZIGBEE_MANFACTURER = 'zigbeeManfacturer';
    public const string KEY_ZWAVE_GENERIC = 'zwaveGeneric';
    public const string KEY_ZWAVE_MANUFACTURER = 'zwaveManufacturer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverFingerprintInterface;
}
