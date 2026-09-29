<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceCapabilityDataAlertItemLastUpdateTime implements ServiceCapabilityDataAlertItemLastUpdateTimeInterface
{
    private ?string $value = null;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): ServiceCapabilityDataAlertItemLastUpdateTimeInterface
    {
        $this->value = $value;

        return $this;
    }
}
