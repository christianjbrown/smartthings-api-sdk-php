<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigEntryForDashboardStateInterface
{
    public function getCapability(): ?string;

    public function getComponent(): ?string;

    public function getComposite(): ?bool;

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    public function getFormatInfo(): ?array;

    public function getGroup(): ?string;

    public function getIdx(): ?int;

    /**
     * @return null|array<int, CapabilityValueForDashboardStateInterface>
     */
    public function getValues(): ?array;

    public function getVersion(): ?int;

    public function getVisibleCondition(): ?VisibleConditionForDashboardStateInterface;

    public function setComposite(?bool $value): self;

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $value
     */
    public function setFormatInfo(?array $value): self;

    public function setGroup(?string $value): self;

    public function setIdx(?int $value): self;

    /**
     * @param null|array<int, CapabilityValueForDashboardStateInterface> $value
     */
    public function setValues(?array $value): self;

    public function setVersion(?int $value): self;

    public function setVisibleCondition(?VisibleConditionForDashboardStateInterface $value): self;
}
