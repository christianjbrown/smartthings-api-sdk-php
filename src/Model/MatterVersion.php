<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MatterVersion implements MatterVersionInterface
{
    private ?int $hardware = null;
    private ?string $hardwareLabel = null;
    private ?float $software = null;
    private ?string $softwareLabel = null;

    public function getHardware(): ?int
    {
        return $this->hardware;
    }

    public function getHardwareLabel(): ?string
    {
        return $this->hardwareLabel;
    }

    public function getSoftware(): ?float
    {
        return $this->software;
    }

    public function getSoftwareLabel(): ?string
    {
        return $this->softwareLabel;
    }

    public function setHardware(?int $value): MatterVersionInterface
    {
        $this->hardware = $value;

        return $this;
    }

    public function setHardwareLabel(?string $value): MatterVersionInterface
    {
        $this->hardwareLabel = $value;

        return $this;
    }

    public function setSoftware(?float $value): MatterVersionInterface
    {
        $this->software = $value;

        return $this;
    }

    public function setSoftwareLabel(?string $value): MatterVersionInterface
    {
        $this->softwareLabel = $value;

        return $this;
    }
}
