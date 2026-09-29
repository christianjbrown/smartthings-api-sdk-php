<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandMappingInterface;
use ChristianBrown\SmartThings\Model\CommandMappings;
use ChristianBrown\SmartThings\Model\CommandMappingsInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class CommandMappingsTransformer implements CommandMappingsTransformerInterface
{
    private CommandMappingTransformerInterface $commandMappingTransformer;

    public function __construct(CommandMappingTransformerInterface $commandMappingTransformer)
    {
        $this->commandMappingTransformer = $commandMappingTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandMappingsInterface
    {
        $model = new CommandMappings();

        $this->applyCommands($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCommands(CommandMappings $model, array $data): void
    {
        if (!isset($data[self::KEY_COMMANDS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMANDS])) {
            return;
        }
        $model->setCommands($this->transformListCommandMapping($data[self::KEY_COMMANDS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CommandMappingInterface>
     */
    private function transformListCommandMapping(array $data): array
    {
        return array_values(array_map(fn (array $item): CommandMappingInterface => $this->commandMappingTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
