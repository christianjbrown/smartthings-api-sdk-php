<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusTvDirectionalPadInterface
{
    public function getCapability(): string;

    public function getCommand(): BasicPlusTvDirectionalPadCommandInterface;

    public function getComponent(): string;

    public function getVersion(): ?int;

    public function setVersion(?int $value): self;
}
