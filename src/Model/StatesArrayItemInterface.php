<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StatesArrayItemInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getCapability(): string;

    public function getComponent(): string;

    public function getComposite(): ?bool;

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    public function getFormatInfo(): ?array;

    public function getGroup(): ?string;

    public function getLabel(): string;

    public function getTransient(): ?bool;

    public function getVersion(): ?int;

    public function getVisibleCondition(): ?VisibleConditionForDashboardStateInterface;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setComposite(?bool $value): self;

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $value
     */
    public function setFormatInfo(?array $value): self;

    public function setGroup(?string $value): self;

    public function setTransient(?bool $value): self;

    public function setVersion(?int $value): self;

    public function setVisibleCondition(?VisibleConditionForDashboardStateInterface $value): self;
}
