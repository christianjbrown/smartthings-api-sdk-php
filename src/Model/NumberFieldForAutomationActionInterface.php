<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface NumberFieldForAutomationActionInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getArgumentType(): ?string;

    public function getCommand(): string;

    public function getDescription(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getSupportedValues(): ?string;

    public function getUnit(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setArgumentType(?string $value): self;

    public function setDescription(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setSupportedValues(?string $value): self;

    public function setUnit(?string $value): self;
}
