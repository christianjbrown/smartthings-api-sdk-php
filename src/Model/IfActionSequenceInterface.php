<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IfActionSequenceInterface
{
    public function getElse(): ?string;

    public function getThen(): ?string;

    public function setElse(?string $value): self;

    public function setThen(?string $value): self;
}
