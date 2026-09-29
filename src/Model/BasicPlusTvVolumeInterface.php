<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusTvVolumeInterface
{
    public function getCapability(): string;

    public function getCommand(): BasicPlusTvVolumeCommandInterface;

    public function getComponent(): string;

    public function getLabel(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getStep(): ?float;

    public function getSupportedValues(): ?string;

    public function getValue(): ?string;

    public function getVersion(): ?int;

    public function setLabel(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setStep(?float $value): self;

    public function setSupportedValues(?string $value): self;

    public function setValue(?string $value): self;

    public function setVersion(?int $value): self;
}
