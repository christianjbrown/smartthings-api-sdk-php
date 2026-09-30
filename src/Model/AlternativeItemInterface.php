<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AlternativeItemInterface
{
    public function getDescription(): ?string;

    public function getIconUrl(): ?string;

    public function getKey(): ?string;

    public function getType(): ?string;

    public function getValue(): ?string;

    public function setDescription(?string $value): self;

    public function setIconUrl(?string $value): self;

    public function setType(?string $value): self;
}
