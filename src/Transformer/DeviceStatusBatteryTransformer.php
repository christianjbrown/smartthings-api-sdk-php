<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceStatusBattery;
use ChristianBrown\SmartThings\Model\DeviceStatusBatteryInterface;

use function is_array;
use function sprintf;

final class DeviceStatusBatteryTransformer implements DeviceStatusBatteryTransformerInterface
{
    private DeviceStatusBatteryBatteryTransformerInterface $deviceStatusBatteryBatteryTransformer;

    public function __construct(DeviceStatusBatteryBatteryTransformerInterface $deviceStatusBatteryBatteryTransformer)
    {
        $this->deviceStatusBatteryBatteryTransformer = $deviceStatusBatteryBatteryTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusBatteryInterface
    {
        if (empty($data[self::KEY_BATTERY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_BATTERY));
        }
        if (!is_array($data[self::KEY_BATTERY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_BATTERY));
        }
        $battery = $this->deviceStatusBatteryBatteryTransformer->transform($data[self::KEY_BATTERY]);
        $deviceStatusBattery = new DeviceStatusBattery($battery);

        return $deviceStatusBattery;
    }
}
