<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusLightColorControl implements BasicPlusLightColorControlInterface
{
    private string $capability;
    private BasicPlusLightColorControlColorInterface $color;
    private string $command;
    private string $component;
    private ?string $value = null;
    private ?int $version = null;

    public function __construct(string $component, string $capability, string $command, BasicPlusLightColorControlColorInterface $color)
    {
        $this->component = $component;
        $this->capability = $capability;
        $this->command = $command;
        $this->color = $color;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getColor(): BasicPlusLightColorControlColorInterface
    {
        return $this->color;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setValue(?string $value): BasicPlusLightColorControlInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setVersion(?int $value): BasicPlusLightColorControlInterface
    {
        $this->version = $value;

        return $this;
    }
}
