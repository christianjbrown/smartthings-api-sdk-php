<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PushButtonWithAvailableSize implements PushButtonWithAvailableSizeInterface
{
    private ?string $argument = null;
    private ?string $argumentType = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $availableSizes = null;
    private string $command;
    private ?string $iconUrl = null;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array
    {
        return $this->availableSizes;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function setArgument(?string $value): PushButtonWithAvailableSizeInterface
    {
        $this->argument = $value;

        return $this;
    }

    public function setArgumentType(?string $value): PushButtonWithAvailableSizeInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): PushButtonWithAvailableSizeInterface
    {
        $this->availableSizes = $value;

        return $this;
    }

    public function setIconUrl(?string $value): PushButtonWithAvailableSizeInterface
    {
        $this->iconUrl = $value;

        return $this;
    }
}
