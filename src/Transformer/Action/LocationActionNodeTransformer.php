<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\LocationAction;
use ChristianBrown\SmartThings\Model\LocationActionInterface;

use function is_string;

/**
 * Builds LocationActionInterface from its decoded JSON.
 */
final class LocationActionNodeTransformer implements LocationActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): LocationActionInterface
    {
        $model = new LocationAction();

        self::applyLocationId($model, $data);
        self::applyMode($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(LocationAction $model, array $data): void
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
    private static function applyMode(LocationAction $model, array $data): void
    {
        if (empty($data[self::KEY_MODE])) {
            return;
        }
        if (!is_string($data[self::KEY_MODE])) {
            return;
        }
        $model->setMode($data[self::KEY_MODE]);
    }
}
