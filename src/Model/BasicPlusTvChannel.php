<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusTvChannel implements BasicPlusTvChannelInterface
{
    private ?string $capability;
    private ?BasicPlusTvVolumeCommandInterface $command;
    private ?string $component;
    private ?string $label = null;
    private ?string $value = null;
    private ?int $version = null;

    public function __construct(?string $capability, ?string $component, ?BasicPlusTvVolumeCommandInterface $command)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->command = $command;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getCommand(): ?BasicPlusTvVolumeCommandInterface
    {
        return $this->command;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setLabel(?string $value): BasicPlusTvChannelInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setValue(?string $value): BasicPlusTvChannelInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setVersion(?int $value): BasicPlusTvChannelInterface
    {
        $this->version = $value;

        return $this;
    }
}
