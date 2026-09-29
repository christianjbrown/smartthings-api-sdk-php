<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AttributePropertiesInterface;
use ChristianBrown\SmartThings\Model\AttributeSchema;
use ChristianBrown\SmartThings\Model\AttributeSchemaInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class AttributeSchemaTransformer implements AttributeSchemaTransformerInterface
{
    private AttributePropertiesTransformerInterface $attributePropertiesTransformer;

    public function __construct(AttributePropertiesTransformerInterface $attributePropertiesTransformer)
    {
        $this->attributePropertiesTransformer = $attributePropertiesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributeSchemaInterface
    {
        $model = new AttributeSchema($this->requireProperties($data));

        self::applyTitle($model, $data);
        self::applyType($model, $data);
        self::applySensitive($model, $data);
        self::applyAdditionalProperties($model, $data);
        self::applyRequired($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdditionalProperties(AttributeSchema $model, array $data): void
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
    private static function applyRequired(AttributeSchema $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applySensitive(AttributeSchema $model, array $data): void
    {
        if (!isset($data[self::KEY_SENSITIVE])) {
            return;
        }
        if (!is_bool($data[self::KEY_SENSITIVE])) {
            return;
        }
        $model->setSensitive($data[self::KEY_SENSITIVE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(AttributeSchema $model, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $model->setTitle($data[self::KEY_TITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(AttributeSchema $model, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $model->setType($data[self::KEY_TYPE]);
    }

    /**
     * @param mixed[] $data
     */
    private function requireProperties(array $data): AttributePropertiesInterface
    {
        if (!isset($data[self::KEY_PROPERTIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_PROPERTIES));
        }
        if (!is_array($data[self::KEY_PROPERTIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_PROPERTIES));
        }

        return $this->attributePropertiesTransformer->transform($data[self::KEY_PROPERTIES]);
    }
}
