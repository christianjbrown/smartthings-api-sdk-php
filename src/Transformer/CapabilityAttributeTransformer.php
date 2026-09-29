<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttribute;
use ChristianBrown\SmartThings\Model\CapabilityAttributeInterface;
use ChristianBrown\SmartThings\Model\EnumCommandInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class CapabilityAttributeTransformer implements CapabilityAttributeTransformerInterface
{
    private AttributeSchemaTransformerInterface $attributeSchemaTransformer;
    private EnumCommandTransformerInterface $enumCommandTransformer;

    public function __construct(AttributeSchemaTransformerInterface $attributeSchemaTransformer, EnumCommandTransformerInterface $enumCommandTransformer)
    {
        $this->attributeSchemaTransformer = $attributeSchemaTransformer;
        $this->enumCommandTransformer = $enumCommandTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityAttributeInterface
    {
        $model = new CapabilityAttribute();

        $this->applySchema($model, $data);
        self::applySetter($model, $data);
        $this->applyEnumCommands($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEnumCommands(CapabilityAttribute $model, array $data): void
    {
        if (!isset($data[self::KEY_ENUM_COMMANDS])) {
            return;
        }
        if (!is_array($data[self::KEY_ENUM_COMMANDS])) {
            return;
        }
        $model->setEnumCommands($this->transformListEnumCommand($data[self::KEY_ENUM_COMMANDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySchema(CapabilityAttribute $model, array $data): void
    {
        if (!isset($data[self::KEY_SCHEMA])) {
            return;
        }
        if (!is_array($data[self::KEY_SCHEMA])) {
            return;
        }
        $model->setSchema($this->attributeSchemaTransformer->transform($data[self::KEY_SCHEMA]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySetter(CapabilityAttribute $model, array $data): void
    {
        if (empty($data[self::KEY_SETTER])) {
            return;
        }
        if (!is_string($data[self::KEY_SETTER])) {
            return;
        }
        $model->setSetter($data[self::KEY_SETTER]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, EnumCommandInterface>
     */
    private function transformListEnumCommand(array $data): array
    {
        return array_values(array_map(fn (array $item): EnumCommandInterface => $this->enumCommandTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
