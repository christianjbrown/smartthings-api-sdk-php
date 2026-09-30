<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusCameraImageInterface
{
    public function getCapability(): ?string;

    public function getComponent(): ?string;

    public function getValue(): ?string;

    public function getVersion(): ?int;

    public function setVersion(?int $value): self;
}
