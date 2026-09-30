<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityCommand;
use ChristianBrown\SmartThings\Model\CapabilityCommandInterface;
use ChristianBrown\SmartThings\Model\CommandArgumentInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;

final class CapabilityCommandTransformer implements CapabilityCommandTransformerInterface
{
    private CommandArgumentTransformerInterface $commandArgumentTransformer;

    public function __construct(CommandArgumentTransformerInterface $commandArgumentTransformer)
    {
        $this->commandArgumentTransformer = $commandArgumentTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityCommandInterface
    {
        $model = new CapabilityCommand(self::requireName($data));

        $this->applyArguments($model, $data);
        self::applySensitive($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyArguments(CapabilityCommand $model, array $data): void
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return;
        }
        $model->setArguments($this->transformListCommandArgument($data[self::KEY_ARGUMENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySensitive(CapabilityCommand $model, array $data): void
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
     * @param mixed[] $data
     */
    private static function requireName(array $data): ?string
    {
        if (empty($data[self::KEY_NAME])) {
            return null;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return null;
        }

        return $data[self::KEY_NAME];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CommandArgumentInterface>
     */
    private function transformListCommandArgument(array $data): array
    {
        return array_values(array_map(fn (array $item): CommandArgumentInterface => $this->commandArgumentTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
