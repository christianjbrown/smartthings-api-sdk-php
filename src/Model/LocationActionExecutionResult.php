<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationActionExecutionResult implements LocationActionExecutionResultInterface
{
    private ?string $locationId = null;
    private ?string $mode = null;
    private ?string $result = null;
    private ?SecurityStateInterface $security = null;

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function getSecurity(): ?SecurityStateInterface
    {
        return $this->security;
    }

    public function setLocationId(?string $value): LocationActionExecutionResultInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setMode(?string $value): LocationActionExecutionResultInterface
    {
        $this->mode = $value;

        return $this;
    }

    public function setResult(?string $value): LocationActionExecutionResultInterface
    {
        $this->result = $value;

        return $this;
    }

    public function setSecurity(?SecurityStateInterface $value): LocationActionExecutionResultInterface
    {
        $this->security = $value;

        return $this;
    }
}
