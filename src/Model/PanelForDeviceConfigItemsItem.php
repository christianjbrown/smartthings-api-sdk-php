<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PanelForDeviceConfigItemsItem implements PanelForDeviceConfigItemsItemInterface
{
    private ?string $capability;
    private ?string $component;
    private ?bool $hideOnUnmatch = null;
    private ?int $idx = null;
    private ?string $operator = null;
    private ?string $size;

    /**
     * @var null|array<int, CapabilityValueForPanelInterface>
     */
    private ?array $values = null;
    private ?int $version = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    public function __construct(?string $component, ?string $capability, ?string $size)
    {
        $this->component = $component;
        $this->capability = $capability;
        $this->size = $size;
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

    public function getIdx(): ?int
    {
        return $this->idx;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * @return null|array<int, CapabilityValueForPanelInterface>
     */
    public function getValues(): ?array
    {
        return $this->values;
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

    public function setHideOnUnmatch(?bool $value): PanelForDeviceConfigItemsItemInterface
    {
        $this->hideOnUnmatch = $value;

        return $this;
    }

    public function setIdx(?int $value): PanelForDeviceConfigItemsItemInterface
    {
        $this->idx = $value;

        return $this;
    }

    public function setOperator(?string $value): PanelForDeviceConfigItemsItemInterface
    {
        $this->operator = $value;

        return $this;
    }

    /**
     * @param null|array<int, CapabilityValueForPanelInterface> $value
     */
    public function setValues(?array $value): PanelForDeviceConfigItemsItemInterface
    {
        $this->values = $value;

        return $this;
    }

    public function setVersion(?int $value): PanelForDeviceConfigItemsItemInterface
    {
        $this->version = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): PanelForDeviceConfigItemsItemInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
