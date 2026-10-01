<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\CommandAction;
use ChristianBrown\SmartThings\Model\CommandActionInterface;
use ChristianBrown\SmartThings\Model\CommandSequenceInterface;
use ChristianBrown\SmartThings\Model\RuleDeviceCommandInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds CommandActionInterface from its decoded JSON.
 */
final class CommandActionNodeTransformer implements CommandActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): CommandActionInterface
    {
        $model = new CommandAction(self::requireDevices($data), self::requireCommands($data, $registry));

        self::applySequence($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySequence(CommandAction $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_SEQUENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_SEQUENCE])) {
            return;
        }
        $model->setSequence($registry->get(CommandSequenceInterface::class)->transform($data[self::KEY_SEQUENCE], $registry));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RuleDeviceCommandInterface>
     */
    private static function requireCommands(array $data, NodeTransformerRegistryInterface $registry): array
    {
        if (!isset($data[self::KEY_COMMANDS])) {
            return [];
        }
        if (!is_array($data[self::KEY_COMMANDS])) {
            return [];
        }

        return self::toRuleDeviceCommandList($data[self::KEY_COMMANDS], $registry);
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

    /**
     * @param mixed[] $data
     *
     * @return array<int, RuleDeviceCommandInterface>
     */
    private static function toRuleDeviceCommandList(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(RuleDeviceCommandInterface::class);

        return array_values(array_map(static fn (array $item): RuleDeviceCommandInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...))));
    }
}
