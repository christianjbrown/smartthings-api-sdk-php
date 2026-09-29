<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CommandMappingsInterface
{
    /**
     * @return null|array<int, CommandMappingInterface>
     */
    public function getCommands(): ?array;

    /**
     * @param null|array<int, CommandMappingInterface> $value
     */
    public function setCommands(?array $value): self;
}
