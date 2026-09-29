<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceCapabilityDataAlertItemSeverityInterface
{
    public function getValue(): ?int;

    public function setValue(?int $value): self;
}
