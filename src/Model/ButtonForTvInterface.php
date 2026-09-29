<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ButtonForTvInterface
{
    public function getArgument(): ?string;

    public function getCapability(): string;

    public function getCommand(): string;

    public function getComponent(): string;

    public function getIconUrl(): ?string;

    public function getVersion(): ?int;

    public function setArgument(?string $value): self;

    public function setIconUrl(?string $value): self;

    public function setVersion(?int $value): self;
}
