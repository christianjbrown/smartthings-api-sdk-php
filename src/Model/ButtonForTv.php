<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ButtonForTv implements ButtonForTvInterface
{
    private ?string $argument = null;
    private ?string $capability;
    private ?string $command;
    private ?string $component;
    private ?string $iconUrl = null;
    private ?int $version = null;

    public function __construct(?string $capability, ?string $component, ?string $command)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->command = $command;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setArgument(?string $value): ButtonForTvInterface
    {
        $this->argument = $value;

        return $this;
    }

    public function setIconUrl(?string $value): ButtonForTvInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setVersion(?int $value): ButtonForTvInterface
    {
        $this->version = $value;

        return $this;
    }
}
