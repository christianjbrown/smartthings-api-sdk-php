<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AttributeDataSchema;
use ChristianBrown\SmartThings\Model\AttributeDataSchemaInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class AttributeDataSchemaTransformer implements AttributeDataSchemaTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeDataSchemaInterface
    {
        $model = new AttributeDataSchema(self::requireType($data));

        self::applyAdditionalProperties($model, $data);
        self::applyRequired($model, $data);
        self::applyProperties($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdditionalProperties(AttributeDataSchema $model, array $data): void
    {
        if (!isset($data[self::KEY_ADDITIONAL_PROPERTIES])) {
            return;
        }
        if (!is_bool($data[self::KEY_ADDITIONAL_PROPERTIES])) {
            return;
        }
        $model->setAdditionalProperties($data[self::KEY_ADDITIONAL_PROPERTIES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProperties(AttributeDataSchema $model, array $data): void
    {
        if (!isset($data[self::KEY_PROPERTIES])) {
            return;
        }
        if (!is_array($data[self::KEY_PROPERTIES])) {
            return;
        }
        $model->setProperties($data[self::KEY_PROPERTIES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRequired(AttributeDataSchema $model, array $data): void
    {
        if (!isset($data[self::KEY_REQUIRED])) {
            return;
        }
        if (!is_array($data[self::KEY_REQUIRED])) {
            return;
        }
        $model->setRequired(array_values(array_filter($data[self::KEY_REQUIRED], is_string(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireType(array $data): string
    {
        if (empty($data[self::KEY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TYPE));
        }
        if (!is_string($data[self::KEY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TYPE));
        }

        return $data[self::KEY_TYPE];
    }
}
