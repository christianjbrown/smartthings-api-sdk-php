<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ModeInterface
{
    public function getId(): string;

    public function getLabel(): ?string;

    public function getName(): ?string;

    public function setId(string $value): self;

    public function setLabel(?string $value): self;

    public function setName(?string $value): self;
}
