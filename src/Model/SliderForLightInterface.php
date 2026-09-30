<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SliderForLightInterface
{
    public function getArgumentType(): ?string;

    public function getCapability(): ?string;

    public function getCommand(): ?string;

    public function getComponent(): ?string;

    public function getLabel(): ?string;

    /**
     * @return mixed[]
     */
    public function getRange(): array;

    public function getStep(): ?float;

    public function getSupportedValues(): ?string;

    public function getUnit(): ?string;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    public function getVersion(): ?int;

    public function setArgumentType(?string $value): self;

    public function setStep(?float $value): self;

    public function setSupportedValues(?string $value): self;

    public function setUnit(?string $value): self;

    public function setValueType(?string $value): self;

    public function setVersion(?int $value): self;
}
