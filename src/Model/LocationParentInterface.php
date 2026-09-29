<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationParentInterface
{
    public function getId(): ?string;

    public function getType(): ?string;

    public function setId(?string $value): self;

    public function setType(?string $value): self;
}
