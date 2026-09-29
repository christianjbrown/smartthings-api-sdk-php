<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PushButtonForPanelItemInterface
{
    public function getArgument(): ?string;

    public function getArgumentType(): ?string;

    public function getCommand(): string;

    public function getIconUrl(): ?string;

    public function getSize(): string;

    public function setArgument(?string $value): self;

    public function setArgumentType(?string $value): self;

    public function setIconUrl(?string $value): self;
}
