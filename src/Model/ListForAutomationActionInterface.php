<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ListForAutomationActionInterface
{
    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array;

    public function getArgumentType(): ?string;

    public function getCommand(): ?string;

    public function getSupportedValues(): ?string;

    public function setArgumentType(?string $value): self;

    public function setCommand(?string $value): self;

    public function setSupportedValues(?string $value): self;
}
