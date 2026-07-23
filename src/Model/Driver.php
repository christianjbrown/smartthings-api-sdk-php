<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Driver implements DriverInterface
{
    private ?string $description = null;
    private string $driverId;
    private ?string $name = null;
    private ?string $packageKey = null;
    private ?string $version = null;

    public function __construct(string $driverId)
    {
        $this->driverId = $driverId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDriverId(): string
    {
        return $this->driverId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPackageKey(): ?string
    {
        return $this->packageKey;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setDescription(?string $value): DriverInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDriverId(string $value): DriverInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setName(?string $value): DriverInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setPackageKey(?string $value): DriverInterface
    {
        $this->packageKey = $value;

        return $this;
    }

    public function setVersion(?string $value): DriverInterface
    {
        $this->version = $value;

        return $this;
    }
}
