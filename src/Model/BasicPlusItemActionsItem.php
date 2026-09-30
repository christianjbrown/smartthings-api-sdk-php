<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusItemActionsItem implements BasicPlusItemActionsItemInterface
{
    private ?string $argument = null;
    private ?string $argumentType = null;
    private ?string $capability;
    private ?string $command;
    private ?string $component;
    private ?string $iconUrl = null;
    private ?string $operator = null;
    private ?int $version = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    public function __construct(?string $command, ?string $component, ?string $capability)
    {
        $this->command = $command;
        $this->component = $component;
        $this->capability = $capability;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
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

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    public function setArgument(?string $value): BasicPlusItemActionsItemInterface
    {
        $this->argument = $value;

        return $this;
    }

    public function setArgumentType(?string $value): BasicPlusItemActionsItemInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setIconUrl(?string $value): BasicPlusItemActionsItemInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setOperator(?string $value): BasicPlusItemActionsItemInterface
    {
        $this->operator = $value;

        return $this;
    }

    public function setVersion(?int $value): BasicPlusItemActionsItemInterface
    {
        $this->version = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): BasicPlusItemActionsItemInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
