<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationParent;
use ChristianBrown\SmartThings\Model\LocationParentInterface;

use function is_string;

final class LocationParentTransformer implements LocationParentTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationParentInterface
    {
        $model = new LocationParent();

        self::applyType($model, $data);
        self::applyId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(LocationParent $model, array $data): void
    {
        if (empty($data[self::KEY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ID])) {
            return;
        }
        $model->setId($data[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(LocationParent $model, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $model->setType($data[self::KEY_TYPE]);
    }
}
