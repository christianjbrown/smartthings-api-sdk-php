<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeProperties;
use ChristianBrown\SmartThings\Model\AttributePropertiesInterface;
use ChristianBrown\SmartThings\Model\AttributeValueSchemaInterface;

use function is_array;

final class AttributePropertiesTransformer implements AttributePropertiesTransformerInterface
{
    private AttributeDataSchemaTransformerInterface $attributeDataSchemaTransformer;
    private AttributeUnitSchemaTransformerInterface $attributeUnitSchemaTransformer;
    private AttributeValueSchemaTransformerInterface $attributeValueSchemaTransformer;

    public function __construct(AttributeValueSchemaTransformerInterface $attributeValueSchemaTransformer, AttributeUnitSchemaTransformerInterface $attributeUnitSchemaTransformer, AttributeDataSchemaTransformerInterface $attributeDataSchemaTransformer)
    {
        $this->attributeValueSchemaTransformer = $attributeValueSchemaTransformer;
        $this->attributeUnitSchemaTransformer = $attributeUnitSchemaTransformer;
        $this->attributeDataSchemaTransformer = $attributeDataSchemaTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AttributePropertiesInterface
    {
        $model = new AttributeProperties($this->requireValue($data));

        $this->applyUnit($model, $data);
        $this->applyData($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyData(AttributeProperties $model, array $data): void
    {
        if (!isset($data[self::KEY_DATA])) {
            return;
        }
        if (!is_array($data[self::KEY_DATA])) {
            return;
        }
        $model->setData($this->attributeDataSchemaTransformer->transform($data[self::KEY_DATA]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUnit(AttributeProperties $model, array $data): void
    {
        if (!isset($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_array($data[self::KEY_UNIT])) {
            return;
        }
        $model->setUnit($this->attributeUnitSchemaTransformer->transform($data[self::KEY_UNIT]));
    }

    /**
     * @param mixed[] $data
     */
    private function requireValue(array $data): ?AttributeValueSchemaInterface
    {
        if (!isset($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return null;
        }

        return $this->attributeValueSchemaTransformer->transform($data[self::KEY_VALUE]);
    }
}
