<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PanelForDeviceConfig implements PanelForDeviceConfigInterface
{
    private ?bool $hideDashboardActions = null;

    /**
     * @var array<int, PanelForDeviceConfigItemsItemInterface>
     */
    private array $items;
    private ?string $operator = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    /**
     * @phpstan-param array<int, PanelForDeviceConfigItemsItemInterface> $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getHideDashboardActions(): ?bool
    {
        return $this->hideDashboardActions;
    }

    /**
     * @return array<int, PanelForDeviceConfigItemsItemInterface>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    public function setHideDashboardActions(?bool $value): PanelForDeviceConfigInterface
    {
        $this->hideDashboardActions = $value;

        return $this;
    }

    public function setOperator(?string $value): PanelForDeviceConfigInterface
    {
        $this->operator = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): PanelForDeviceConfigInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
