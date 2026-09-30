<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusStateBoardItem implements BasicPlusStateBoardItemInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $capability;

    /**
     * @var null|array<int, BasicPlusStateBoardColorsInterface>
     */
    private ?array $colors = null;
    private ?string $component;
    private ?string $iconUrl = null;
    private ?string $label;
    private ?string $operator = null;
    private ?string $unit = null;
    private ?string $value;
    private ?string $valueType = null;
    private ?int $version = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    public function __construct(?string $capability, ?string $component, ?string $value, ?string $label)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    /**
     * @return null|array<int, BasicPlusStateBoardColorsInterface>
     */
    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
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

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): BasicPlusStateBoardItemInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusStateBoardColorsInterface> $value
     */
    public function setColors(?array $value): BasicPlusStateBoardItemInterface
    {
        $this->colors = $value;

        return $this;
    }

    public function setIconUrl(?string $value): BasicPlusStateBoardItemInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setOperator(?string $value): BasicPlusStateBoardItemInterface
    {
        $this->operator = $value;

        return $this;
    }

    public function setUnit(?string $value): BasicPlusStateBoardItemInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValueType(?string $value): BasicPlusStateBoardItemInterface
    {
        $this->valueType = $value;

        return $this;
    }

    public function setVersion(?int $value): BasicPlusStateBoardItemInterface
    {
        $this->version = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): BasicPlusStateBoardItemInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
