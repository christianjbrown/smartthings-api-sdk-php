<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValue;
use ChristianBrown\SmartThings\Model\AttributeValueInterface;

use function is_array;
use function is_string;

final class AttributeValueTransformer implements AttributeValueTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeValueInterface
    {
        $model = new AttributeValue();

        self::applyAttribute($model, $data);
        self::applyInputType($model, $data);
        self::applyStaticValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAttribute(AttributeValue $model, array $data): void
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        $model->setAttribute($data[self::KEY_ATTRIBUTE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInputType(AttributeValue $model, array $data): void
    {
        if (empty($data[self::KEY_INPUT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_INPUT_TYPE])) {
            return;
        }
        $model->setInputType($data[self::KEY_INPUT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStaticValue(AttributeValue $model, array $data): void
    {
        if (!isset($data[self::KEY_STATIC_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATIC_VALUE])) {
            return;
        }
        $model->setStaticValue($data[self::KEY_STATIC_VALUE]);
    }
}
