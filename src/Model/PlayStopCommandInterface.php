<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PlayStopCommandInterface
{
    public function getArgumentType(): ?string;

    public function getName(): ?string;

    public function getPlay(): ?string;

    public function getStop(): ?string;

    public function setArgumentType(?string $value): self;

    public function setName(?string $value): self;
}
