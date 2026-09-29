<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceCapabilityDataAlertItemLastUpdateTimeInterface
{
    public function getValue(): ?string;

    public function setValue(?string $value): self;
}
