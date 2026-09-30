<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValueInterface;
use ChristianBrown\SmartThings\Model\CommandMapping;
use ChristianBrown\SmartThings\Model\CommandMappingInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;

final class CommandMappingTransformer implements CommandMappingTransformerInterface
{
    private AttributeValueTransformerInterface $attributeValueTransformer;

    public function __construct(AttributeValueTransformerInterface $attributeValueTransformer)
    {
        $this->attributeValueTransformer = $attributeValueTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandMappingInterface
    {
        $model = new CommandMapping(self::requireCapabilityId($data), self::requireVersion($data), self::requireCommand($data), $this->requireEventValues($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapabilityId(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY_ID])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCommand(array $data): ?string
    {
        if (empty($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return null;
        }

        return $data[self::KEY_COMMAND];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AttributeValueInterface>
     */
    private function requireEventValues(array $data): array
    {
        if (!isset($data[self::KEY_EVENT_VALUES])) {
            return [];
        }
        if (!is_array($data[self::KEY_EVENT_VALUES])) {
            return [];
        }

        return $this->transformListAttributeValue($data[self::KEY_EVENT_VALUES]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireVersion(array $data): ?int
    {
        if (!isset($data[self::KEY_VERSION])) {
            return null;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return null;
        }

        return $data[self::KEY_VERSION];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AttributeValueInterface>
     */
    private function transformListAttributeValue(array $data): array
    {
        return array_values(array_map(fn (array $item): AttributeValueInterface => $this->attributeValueTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
