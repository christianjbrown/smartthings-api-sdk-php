<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface VisibleConditionForDetailViewInterface
{
    public function getCapability(): string;

    public function getComponent(): string;

    public function getHideOnUnmatch(): ?bool;

    public function getOperand(): string;

    public function getOperator(): string;

    public function getValue(): string;

    public function getValueType(): ?string;

    public function getVersion(): ?int;

    public function setHideOnUnmatch(?bool $value): self;

    public function setValueType(?string $value): self;

    public function setVersion(?int $value): self;
}
