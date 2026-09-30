<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PanelForDeviceConfigItemsItemInterface
{
    public function getCapability(): ?string;

    public function getComponent(): ?string;

    public function getHideOnUnmatch(): ?bool;

    public function getIdx(): ?int;

    public function getOperator(): ?string;

    public function getSize(): ?string;

    /**
     * @return null|array<int, CapabilityValueForPanelInterface>
     */
    public function getValues(): ?array;

    public function getVersion(): ?int;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    public function setHideOnUnmatch(?bool $value): self;

    public function setIdx(?int $value): self;

    public function setOperator(?string $value): self;

    /**
     * @param null|array<int, CapabilityValueForPanelInterface> $value
     */
    public function setValues(?array $value): self;

    public function setVersion(?int $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
