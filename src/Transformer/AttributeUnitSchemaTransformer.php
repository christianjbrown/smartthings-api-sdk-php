<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeUnitSchema;
use ChristianBrown\SmartThings\Model\AttributeUnitSchemaInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class AttributeUnitSchemaTransformer implements AttributeUnitSchemaTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeUnitSchemaInterface
    {
        $model = new AttributeUnitSchema();

        self::applyType($model, $data);
        self::applyEnum($model, $data);
        self::applyDefault($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDefault(AttributeUnitSchema $model, array $data): void
    {
        if (empty($data[self::KEY_DEFAULT])) {
            return;
        }
        if (!is_string($data[self::KEY_DEFAULT])) {
            return;
        }
        $model->setDefault($data[self::KEY_DEFAULT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnum(AttributeUnitSchema $model, array $data): void
    {
        if (!isset($data[self::KEY_ENUM])) {
            return;
        }
        if (!is_array($data[self::KEY_ENUM])) {
            return;
        }
        $model->setEnum(array_values(array_filter($data[self::KEY_ENUM], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(AttributeUnitSchema $model, array $data): void
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
