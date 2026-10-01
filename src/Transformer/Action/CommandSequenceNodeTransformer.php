<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\CommandSequence;
use ChristianBrown\SmartThings\Model\CommandSequenceInterface;

use function is_string;

/**
 * Builds CommandSequenceInterface from its decoded JSON.
 */
final class CommandSequenceNodeTransformer implements CommandSequenceNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): CommandSequenceInterface
    {
        $model = new CommandSequence();

        self::applyCommands($model, $data);
        self::applyDevices($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommands(CommandSequence $model, array $data): void
    {
        if (empty($data[self::KEY_COMMANDS])) {
            return;
        }
        if (!is_string($data[self::KEY_COMMANDS])) {
            return;
        }
        $model->setCommands($data[self::KEY_COMMANDS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDevices(CommandSequence $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICES])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICES])) {
            return;
        }
        $model->setDevices($data[self::KEY_DEVICES]);
    }
}
