<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface NumberFieldForAutomationConditionInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getDescription(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getSupportedValues(): ?string;

    public function getUnit(): ?string;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setDescription(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setSupportedValues(?string $value): self;

    public function setUnit(?string $value): self;

    public function setValueType(?string $value): self;
}
