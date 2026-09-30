<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusTvChannelInterface
{
    public function getCapability(): ?string;

    public function getCommand(): ?BasicPlusTvVolumeCommandInterface;

    public function getComponent(): ?string;

    public function getLabel(): ?string;

    public function getValue(): ?string;

    public function getVersion(): ?int;

    public function setLabel(?string $value): self;

    public function setValue(?string $value): self;

    public function setVersion(?int $value): self;
}
