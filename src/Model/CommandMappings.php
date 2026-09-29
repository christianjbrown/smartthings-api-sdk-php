<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CommandMappings implements CommandMappingsInterface
{
    /**
     * @var null|array<int, CommandMappingInterface>
     */
    private ?array $commands = null;

    /**
     * @return null|array<int, CommandMappingInterface>
     */
    public function getCommands(): ?array
    {
        return $this->commands;
    }

    /**
     * @param null|array<int, CommandMappingInterface> $value
     */
    public function setCommands(?array $value): CommandMappingsInterface
    {
        $this->commands = $value;

        return $this;
    }
}
