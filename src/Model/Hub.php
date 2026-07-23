<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Hub implements HubInterface
{
    private ?string $eui = null;
    private ?string $firmwareVersion = null;
    private string $id;
    private ?string $name = null;
    private ?string $owner = null;
    private ?string $serialNumber = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getEui(): ?string
    {
        return $this->eui;
    }

    public function getFirmwareVersion(): ?string
    {
        return $this->firmwareVersion;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setEui(?string $value): HubInterface
    {
        $this->eui = $value;

        return $this;
    }

    public function setFirmwareVersion(?string $value): HubInterface
    {
        $this->firmwareVersion = $value;

        return $this;
    }

    public function setId(string $value): HubInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setName(?string $value): HubInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setOwner(?string $value): HubInterface
    {
        $this->owner = $value;

        return $this;
    }

    public function setSerialNumber(?string $value): HubInterface
    {
        $this->serialNumber = $value;

        return $this;
    }
}
