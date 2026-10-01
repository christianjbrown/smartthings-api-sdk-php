<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\ToggleAction;
use ChristianBrown\SmartThings\Model\ToggleActionInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds ToggleActionInterface from its decoded JSON.
 */
final class ToggleActionNodeTransformer implements ToggleActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): ToggleActionInterface
    {
        $model = new ToggleAction(self::requireDevices($data), self::requireComponent($data), self::requireCapability($data), self::requireAttribute($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireAttribute(array $data): ?string
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return null;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return null;
        }

        return $data[self::KEY_ATTRIBUTE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    private static function requireDevices(array $data): array
    {
        if (!isset($data[self::KEY_DEVICES])) {
            return [];
        }
        if (!is_array($data[self::KEY_DEVICES])) {
            return [];
        }

        return array_values(array_filter($data[self::KEY_DEVICES], is_string(...)));
    }
}
