<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusTvDirectionalPad implements BasicPlusTvDirectionalPadInterface
{
    private string $capability;
    private BasicPlusTvDirectionalPadCommandInterface $command;
    private string $component;
    private ?int $version = null;

    public function __construct(string $capability, string $component, BasicPlusTvDirectionalPadCommandInterface $command)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->command = $command;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getCommand(): BasicPlusTvDirectionalPadCommandInterface
    {
        return $this->command;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(?int $value): BasicPlusTvDirectionalPadInterface
    {
        $this->version = $value;

        return $this;
    }
}
