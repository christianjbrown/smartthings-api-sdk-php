<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusLightColorControlInterface
{
    public function getCapability(): string;

    public function getColor(): BasicPlusLightColorControlColorInterface;

    public function getCommand(): string;

    public function getComponent(): string;

    public function getValue(): ?string;

    public function getVersion(): ?int;

    public function setValue(?string $value): self;

    public function setVersion(?int $value): self;
}
