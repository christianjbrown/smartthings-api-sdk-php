<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceIntegrationProfileKey implements DeviceIntegrationProfileKeyInterface
{
    private ?string $id = null;
    private ?int $majorVersion = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getMajorVersion(): ?int
    {
        return $this->majorVersion;
    }

    public function setId(?string $value): DeviceIntegrationProfileKeyInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setMajorVersion(?int $value): DeviceIntegrationProfileKeyInterface
    {
        $this->majorVersion = $value;

        return $this;
    }
}
