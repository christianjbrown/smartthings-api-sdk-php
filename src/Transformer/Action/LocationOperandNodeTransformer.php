<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\LocationOperand;
use ChristianBrown\SmartThings\Model\LocationOperandInterface;

use function is_string;

/**
 * Builds LocationOperandInterface from its decoded JSON.
 */
final class LocationOperandNodeTransformer implements LocationOperandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): LocationOperandInterface
    {
        $model = new LocationOperand(self::requireAttribute($data));

        self::applyLocationId($model, $data);
        self::applyPostalCode($model, $data);
        self::applyTrigger($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(LocationOperand $model, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $model->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(LocationOperand $model, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $model->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTrigger(LocationOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TRIGGER])) {
            return;
        }
        if (!is_string($data[self::KEY_TRIGGER])) {
            return;
        }
        $model->setTrigger($data[self::KEY_TRIGGER]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireAttribute(array $data): ?string
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return null;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return null;
        }

        return $data[self::KEY_ATTRIBUTE];
    }
}
