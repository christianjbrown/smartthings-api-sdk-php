<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PushButtonForPanelItem implements PushButtonForPanelItemInterface
{
    private ?string $argument = null;
    private ?string $argumentType = null;
    private string $command;
    private ?string $iconUrl = null;
    private string $size;

    public function __construct(string $command, string $size)
    {
        $this->command = $command;
        $this->size = $size;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setArgument(?string $value): PushButtonForPanelItemInterface
    {
        $this->argument = $value;

        return $this;
    }

    public function setArgumentType(?string $value): PushButtonForPanelItemInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setIconUrl(?string $value): PushButtonForPanelItemInterface
    {
        $this->iconUrl = $value;

        return $this;
    }
}
