<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Device;
use ChristianBrown\SmartThings\Model\DeviceInterface;

use function is_array;
use function is_string;
use function sprintf;

final class DeviceTransformer implements DeviceTransformerInterface
{
    private DeviceComponentsTransformerInterface $deviceComponentsTransformer;

    public function __construct(DeviceComponentsTransformerInterface $deviceComponentsTransformer)
    {
        $this->deviceComponentsTransformer = $deviceComponentsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceInterface
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DEVICE_ID));
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DEVICE_ID));
        }
        $device = new Device($data[self::KEY_DEVICE_ID]);

        $this->applyLabel($device, $data);
        $this->applyLocationId($device, $data);
        $this->applyName($device, $data);
        $this->applyRoomId($device, $data);
        $this->applyComponents($device, $data);

        return $device;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyComponents(Device $device, array $data): void
    {
        if (empty($data[self::KEY_COMPONENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMPONENTS])) {
            return;
        }
        $components = $this->deviceComponentsTransformer->transform($data[self::KEY_COMPONENTS]);
        $device->setComponents($components);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLabel(Device $device, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $device->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLocationId(Device $device, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $device->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyName(Device $device, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $device->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRoomId(Device $device, array $data): void
    {
        if (empty($data[self::KEY_ROOM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ROOM_ID])) {
            return;
        }
        $device->setRoomId($data[self::KEY_ROOM_ID]);
    }
}
