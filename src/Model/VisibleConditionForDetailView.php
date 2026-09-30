<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class VisibleConditionForDetailView implements VisibleConditionForDetailViewInterface
{
    private ?string $capability;
    private ?string $component;
    private ?bool $hideOnUnmatch = null;
    private ?string $operand;
    private ?string $operator;
    private ?string $value;
    private ?string $valueType = null;
    private ?int $version = null;

    public function __construct(?string $value, ?string $operator, ?string $operand, ?string $component, ?string $capability)
    {
        $this->value = $value;
        $this->operator = $operator;
        $this->operand = $operand;
        $this->component = $component;
        $this->capability = $capability;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getHideOnUnmatch(): ?bool
    {
        return $this->hideOnUnmatch;
    }

    public function getOperand(): ?string
    {
        return $this->operand;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setHideOnUnmatch(?bool $value): VisibleConditionForDetailViewInterface
    {
        $this->hideOnUnmatch = $value;

        return $this;
    }

    public function setValueType(?string $value): VisibleConditionForDetailViewInterface
    {
        $this->valueType = $value;

        return $this;
    }

    public function setVersion(?int $value): VisibleConditionForDetailViewInterface
    {
        $this->version = $value;

        return $this;
    }
}
