<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DynamicListForAutomationActionInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getArgumentType(): ?string;

    public function getCommand(): ?string;

    public function getSupportedValues(): ?SupportedValuesForDynamicListInterface;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setArgumentType(?string $value): self;

    public function setCommand(?string $value): self;
}
