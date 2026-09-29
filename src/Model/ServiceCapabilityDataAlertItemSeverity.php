<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceCapabilityDataAlertItemSeverity implements ServiceCapabilityDataAlertItemSeverityInterface
{
    private ?int $value = null;

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): ServiceCapabilityDataAlertItemSeverityInterface
    {
        $this->value = $value;

        return $this;
    }
}
