<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SliderForPanelItemInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getArgumentType(): ?string;

    public function getCommand(): ?string;

    /**
     * @return mixed[]
     */
    public function getRange(): array;

    public function getSize(): ?string;

    public function getStep(): ?float;

    public function getSupportedValues(): ?string;

    public function getUnit(): ?string;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setArgumentType(?string $value): self;

    public function setStep(?float $value): self;

    public function setSupportedValues(?string $value): self;

    public function setUnit(?string $value): self;

    public function setValue(?string $value): self;

    public function setValueType(?string $value): self;
}
