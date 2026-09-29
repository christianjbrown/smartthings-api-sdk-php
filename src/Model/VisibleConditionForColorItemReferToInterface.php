<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface VisibleConditionForColorItemReferToInterface
{
    public function getCapability(): string;

    public function getComponent(): string;

    public function getValue(): string;

    public function getValueType(): ?string;

    public function getVersion(): ?int;

    public function setValueType(?string $value): self;

    public function setVersion(?int $value): self;
}
