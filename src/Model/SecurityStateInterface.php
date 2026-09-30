<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SecurityStateInterface
{
    public function getArmState(): ?string;

    public function getMonitoring(): ?bool;

    public function setArmState(?string $value): self;

    public function setMonitoring(?bool $value): self;
}
