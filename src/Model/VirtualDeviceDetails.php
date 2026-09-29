<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class VirtualDeviceDetails implements VirtualDeviceDetailsInterface
{
    private ?CommandMappingsInterface $commandMappings = null;
    private ?string $driverId = null;
    private ?bool $executingLocally = null;
    private ?string $hubId = null;
    private ?string $name = null;

    public function getCommandMappings(): ?CommandMappingsInterface
    {
        return $this->commandMappings;
    }

    public function getDriverId(): ?string
    {
        return $this->driverId;
    }

    public function getExecutingLocally(): ?bool
    {
        return $this->executingLocally;
    }

    public function getHubId(): ?string
    {
        return $this->hubId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setCommandMappings(?CommandMappingsInterface $value): VirtualDeviceDetailsInterface
    {
        $this->commandMappings = $value;

        return $this;
    }

    public function setDriverId(?string $value): VirtualDeviceDetailsInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setExecutingLocally(?bool $value): VirtualDeviceDetailsInterface
    {
        $this->executingLocally = $value;

        return $this;
    }

    public function setHubId(?string $value): VirtualDeviceDetailsInterface
    {
        $this->hubId = $value;

        return $this;
    }

    public function setName(?string $value): VirtualDeviceDetailsInterface
    {
        $this->name = $value;

        return $this;
    }
}
