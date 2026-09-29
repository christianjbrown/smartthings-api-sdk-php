<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PanelForDevicePresentationInterface
{
    public function getHideDashboardActions(): ?bool;

    /**
     * @return array<int, PanelForDevicePresentationItemsItemInterface>
     */
    public function getItems(): array;

    public function getOperator(): ?string;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    public function setHideDashboardActions(?bool $value): self;

    public function setOperator(?string $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
