<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusTvVolumeCommandInterface
{
    public function getDecrease(): ?string;

    public function getIncrease(): ?string;

    public function getName(): ?string;

    public function setDecrease(?string $value): self;

    public function setIncrease(?string $value): self;

    public function setName(?string $value): self;
}
