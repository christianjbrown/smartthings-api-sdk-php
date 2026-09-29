<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceRelationship;
use ChristianBrown\SmartThings\Model\DeviceRelationshipInterface;

use function is_string;

final class DeviceRelationshipTransformer implements DeviceRelationshipTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceRelationshipInterface
    {
        $model = new DeviceRelationship();

        self::applyDeviceId($model, $data);
        self::applyRelationshipType($model, $data);
        self::applyOnDelete($model, $data);
        self::applyOnLocationMove($model, $data);
        self::applyOnOwnershipTransfer($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceId(DeviceRelationship $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            return;
        }
        $model->setDeviceId($data[self::KEY_DEVICE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOnDelete(DeviceRelationship $model, array $data): void
    {
        if (empty($data[self::KEY_ON_DELETE])) {
            return;
        }
        if (!is_string($data[self::KEY_ON_DELETE])) {
            return;
        }
        $model->setOnDelete($data[self::KEY_ON_DELETE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOnLocationMove(DeviceRelationship $model, array $data): void
    {
        if (empty($data[self::KEY_ON_LOCATION_MOVE])) {
            return;
        }
        if (!is_string($data[self::KEY_ON_LOCATION_MOVE])) {
            return;
        }
        $model->setOnLocationMove($data[self::KEY_ON_LOCATION_MOVE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOnOwnershipTransfer(DeviceRelationship $model, array $data): void
    {
        if (empty($data[self::KEY_ON_OWNERSHIP_TRANSFER])) {
            return;
        }
        if (!is_string($data[self::KEY_ON_OWNERSHIP_TRANSFER])) {
            return;
        }
        $model->setOnOwnershipTransfer($data[self::KEY_ON_OWNERSHIP_TRANSFER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRelationshipType(DeviceRelationship $model, array $data): void
    {
        if (empty($data[self::KEY_RELATIONSHIP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_RELATIONSHIP_TYPE])) {
            return;
        }
        $model->setRelationshipType($data[self::KEY_RELATIONSHIP_TYPE]);
    }
}
