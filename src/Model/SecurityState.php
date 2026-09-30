<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SecurityState implements SecurityStateInterface
{
    private ?string $armState = null;
    private ?bool $monitoring = null;

    public function getArmState(): ?string
    {
        return $this->armState;
    }

    public function getMonitoring(): ?bool
    {
        return $this->monitoring;
    }

    public function setArmState(?string $value): SecurityStateInterface
    {
        $this->armState = $value;

        return $this;
    }

    public function setMonitoring(?bool $value): SecurityStateInterface
    {
        $this->monitoring = $value;

        return $this;
    }
}
