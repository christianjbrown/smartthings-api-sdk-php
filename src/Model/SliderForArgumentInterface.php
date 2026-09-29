<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SliderForArgumentInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getArgumentType(): ?string;

    public function getName(): string;

    /**
     * @return mixed[]
     */
    public function getRange(): array;

    public function getStep(): ?float;

    public function getSupportedValues(): ?string;

    public function getUnit(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setArgumentType(?string $value): self;

    public function setStep(?float $value): self;

    public function setSupportedValues(?string $value): self;

    public function setUnit(?string $value): self;
}
