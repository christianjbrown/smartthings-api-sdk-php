<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\RuleDeviceCommand;
use ChristianBrown\SmartThings\Model\RuleDeviceCommandInterface;

use function is_array;
use function is_string;

/**
 * Builds RuleDeviceCommandInterface from its decoded JSON.
 */
final class RuleDeviceCommandNodeTransformer implements RuleDeviceCommandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): RuleDeviceCommandInterface
    {
        $model = new RuleDeviceCommand(self::requireCapability($data), self::requireCommand($data));

        self::applyComponent($model, $data);
        self::applyArguments($model, $data);
        self::applyCommandId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArguments(RuleDeviceCommand $model, array $data): void
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return;
        }
        $model->setArguments($data[self::KEY_ARGUMENTS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommandId(RuleDeviceCommand $model, array $data): void
    {
        if (empty($data[self::KEY_COMMAND_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_COMMAND_ID])) {
            return;
        }
        $model->setCommandId($data[self::KEY_COMMAND_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponent(RuleDeviceCommand $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return;
        }
        $model->setComponent($data[self::KEY_COMPONENT]);
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
}
