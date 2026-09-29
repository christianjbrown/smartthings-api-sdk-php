<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Device;
use ChristianBrown\SmartThings\Model\DeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;
use function sprintf;

final class DeviceTransformer implements DeviceTransformerInterface
{
    private DeviceComponentsTransformerInterface $deviceComponentsTransformer;
    private DeviceDetailsTransformerInterface $deviceDetailsTransformer;

    public function __construct(DeviceComponentsTransformerInterface $deviceComponentsTransformer, DeviceDetailsTransformerInterface $deviceDetailsTransformer)
    {
        $this->deviceComponentsTransformer = $deviceComponentsTransformer;
        $this->deviceDetailsTransformer = $deviceDetailsTransformer;
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

        self::applyLabel($device, $data);
        self::applyLocationId($device, $data);
        self::applyName($device, $data);
        self::applyRoomId($device, $data);
        $this->applyComponents($device, $data);

        self::applyManufacturerName($device, $data);
        self::applyPresentationId($device, $data);
        self::applyDeviceManufacturerCode($device, $data);
        self::applyOwnerId($device, $data);
        self::applyDeviceTypeId($device, $data);
        self::applyDeviceTypeName($device, $data);
        self::applyDeviceNetworkType($device, $data);
        self::applyProductId($device, $data);
        self::applyBrandId($device, $data);
        self::applyCreateTime($device, $data);
        self::applyParentDeviceId($device, $data);
        self::applyBle($device, $data);
        self::applyType($device, $data);
        self::applyRestrictionTier($device, $data);
        self::applyAllowed($device, $data);
        self::applyExecutionContext($device, $data);

        $this->applyDetails($device, $data);

        $this->applyChildDevices($device, $data);

        return $device;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAllowed(Device $model, array $data): void
    {
        if (!isset($data[self::KEY_ALLOWED])) {
            return;
        }
        if (!is_array($data[self::KEY_ALLOWED])) {
            return;
        }
        $model->setAllowed(array_values(array_filter($data[self::KEY_ALLOWED], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBle(Device $model, array $data): void
    {
        if (!isset($data[self::KEY_BLE])) {
            return;
        }
        if (!is_array($data[self::KEY_BLE])) {
            return;
        }
        $model->setBle($data[self::KEY_BLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBrandId(Device $model, array $data): void
    {
        if (empty($data[self::KEY_BRAND_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_BRAND_ID])) {
            return;
        }
        $model->setBrandId($data[self::KEY_BRAND_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyChildDevices(Device $model, array $data): void
    {
        if (!isset($data[self::KEY_CHILD_DEVICES])) {
            return;
        }
        if (!is_array($data[self::KEY_CHILD_DEVICES])) {
            return;
        }
        $model->setChildDevices(array_values(array_map(fn (array $item): DeviceInterface => $this->transform($item), array_filter($data[self::KEY_CHILD_DEVICES], is_array(...)))));
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
    private static function applyCreateTime(Device $model, array $data): void
    {
        if (empty($data[self::KEY_CREATE_TIME])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATE_TIME])) {
            return;
        }
        $model->setCreateTime($data[self::KEY_CREATE_TIME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(Device $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->deviceDetailsTransformer->transform($data);
        self::copyHealthState($model, $details);
        self::copyProfile($model, $details);
        self::copyApp($model, $details);
        self::copyBleD2D($model, $details);
        self::copyDth($model, $details);
        self::copyLan($model, $details);
        self::copyZigbee($model, $details);
        self::copyZwave($model, $details);
        self::copyMatter($model, $details);
        self::copyHub($model, $details);
        self::copyEdgeChild($model, $details);
        self::copyIr($model, $details);
        self::copyIrOcf($model, $details);
        self::copyOcf($model, $details);
        self::copyViper($model, $details);
        self::copyGroup($model, $details);
        self::copyVirtual($model, $details);
        self::copyMqtt($model, $details);
        self::copyIndoorMap($model, $details);
        self::copyRelationships($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceManufacturerCode(Device $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_MANUFACTURER_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_MANUFACTURER_CODE])) {
            return;
        }
        $model->setDeviceManufacturerCode($data[self::KEY_DEVICE_MANUFACTURER_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceNetworkType(Device $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_NETWORK_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_NETWORK_TYPE])) {
            return;
        }
        $model->setDeviceNetworkType($data[self::KEY_DEVICE_NETWORK_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceTypeId(Device $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_TYPE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_TYPE_ID])) {
            return;
        }
        $model->setDeviceTypeId($data[self::KEY_DEVICE_TYPE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceTypeName(Device $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_TYPE_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_TYPE_NAME])) {
            return;
        }
        $model->setDeviceTypeName($data[self::KEY_DEVICE_TYPE_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutionContext(Device $model, array $data): void
    {
        if (empty($data[self::KEY_EXECUTION_CONTEXT])) {
            return;
        }
        if (!is_string($data[self::KEY_EXECUTION_CONTEXT])) {
            return;
        }
        $model->setExecutionContext($data[self::KEY_EXECUTION_CONTEXT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(Device $device, array $data): void
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
    private static function applyLocationId(Device $device, array $data): void
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
    private static function applyManufacturerName(Device $model, array $data): void
    {
        if (empty($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        $model->setManufacturerName($data[self::KEY_MANUFACTURER_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Device $device, array $data): void
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
    private static function applyOwnerId(Device $model, array $data): void
    {
        if (empty($data[self::KEY_OWNER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_OWNER_ID])) {
            return;
        }
        $model->setOwnerId($data[self::KEY_OWNER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyParentDeviceId(Device $model, array $data): void
    {
        if (empty($data[self::KEY_PARENT_DEVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PARENT_DEVICE_ID])) {
            return;
        }
        $model->setParentDeviceId($data[self::KEY_PARENT_DEVICE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPresentationId(Device $model, array $data): void
    {
        if (empty($data[self::KEY_PRESENTATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PRESENTATION_ID])) {
            return;
        }
        $model->setPresentationId($data[self::KEY_PRESENTATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProductId(Device $model, array $data): void
    {
        if (empty($data[self::KEY_PRODUCT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PRODUCT_ID])) {
            return;
        }
        $model->setProductId($data[self::KEY_PRODUCT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRestrictionTier(Device $model, array $data): void
    {
        if (!isset($data[self::KEY_RESTRICTION_TIER])) {
            return;
        }
        if (!is_int($data[self::KEY_RESTRICTION_TIER])) {
            return;
        }
        $model->setRestrictionTier($data[self::KEY_RESTRICTION_TIER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRoomId(Device $device, array $data): void
    {
        if (empty($data[self::KEY_ROOM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ROOM_ID])) {
            return;
        }
        $device->setRoomId($data[self::KEY_ROOM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(Device $model, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $model->setType($data[self::KEY_TYPE]);
    }

    private static function copyApp(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setApp($details->getApp());
    }

    private static function copyBleD2D(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setBleD2D($details->getBleD2D());
    }

    private static function copyDth(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setDth($details->getDth());
    }

    private static function copyEdgeChild(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setEdgeChild($details->getEdgeChild());
    }

    private static function copyGroup(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setGroup($details->getGroup());
    }

    private static function copyHealthState(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setHealthState($details->getHealthState());
    }

    private static function copyHub(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setHub($details->getHub());
    }

    private static function copyIndoorMap(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setIndoorMap($details->getIndoorMap());
    }

    private static function copyIr(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setIr($details->getIr());
    }

    private static function copyIrOcf(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setIrOcf($details->getIrOcf());
    }

    private static function copyLan(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setLan($details->getLan());
    }

    private static function copyMatter(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setMatter($details->getMatter());
    }

    private static function copyMqtt(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setMqtt($details->getMqtt());
    }

    private static function copyOcf(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setOcf($details->getOcf());
    }

    private static function copyProfile(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setProfile($details->getProfile());
    }

    private static function copyRelationships(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setRelationships($details->getRelationships() ?? []);
    }

    private static function copyViper(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setViper($details->getViper());
    }

    private static function copyVirtual(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setVirtual($details->getVirtual());
    }

    private static function copyZigbee(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setZigbee($details->getZigbee());
    }

    private static function copyZwave(Device $model, DeviceDetailsInterface $details): void
    {
        $model->setZwave($details->getZwave());
    }
}
