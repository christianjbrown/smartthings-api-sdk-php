<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValueSchema;
use ChristianBrown\SmartThings\Model\AttributeValueSchemaInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class AttributeValueSchemaTransformer implements AttributeValueSchemaTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeValueSchemaInterface
    {
        $model = new AttributeValueSchema();

        self::applyType($model, $data);
        self::applyEnum($model, $data);
        self::applyAdditionalKeywords($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdditionalKeywords(AttributeValueSchema $model, array $data): void
    {
        if (!isset($data[self::KEY_ADDITIONAL_KEYWORDS])) {
            return;
        }
        if (!is_array($data[self::KEY_ADDITIONAL_KEYWORDS])) {
            return;
        }
        $model->setAdditionalKeywords($data[self::KEY_ADDITIONAL_KEYWORDS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnum(AttributeValueSchema $model, array $data): void
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
    private static function applyType(AttributeValueSchema $model, array $data): void
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
