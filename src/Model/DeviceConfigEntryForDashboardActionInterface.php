<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigEntryForDashboardActionInterface
{
    public function getCapability(): string;

    public function getComponent(): string;

    public function getGroup(): ?string;

    public function getIdx(): ?int;

    public function getInline(): ?DeviceConfigEntryForDashboardActionInlineInterface;

    public function getVersion(): ?int;

    public function getVisibleCondition(): ?VisibleConditionInterface;

    public function setGroup(?string $value): self;

    public function setIdx(?int $value): self;

    public function setInline(?DeviceConfigEntryForDashboardActionInlineInterface $value): self;

    public function setVersion(?int $value): self;

    public function setVisibleCondition(?VisibleConditionInterface $value): self;
}
