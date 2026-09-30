<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusTvDirectionalPadCommandInterface
{
    public function getDown(): ?string;

    public function getLeft(): ?string;

    public function getName(): ?string;

    public function getOk(): ?string;

    public function getRight(): ?string;

    public function getUp(): ?string;

    public function setName(?string $value): self;
}
