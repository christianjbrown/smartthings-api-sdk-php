<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubInterface
{
    public function getEui(): ?string;

    public function getFirmwareVersion(): ?string;

    public function getId(): string;

    public function getName(): ?string;

    public function getOwner(): ?string;

    public function getSerialNumber(): ?string;

    public function setEui(?string $value): self;

    public function setFirmwareVersion(?string $value): self;

    public function setId(string $value): self;

    public function setName(?string $value): self;

    public function setOwner(?string $value): self;

    public function setSerialNumber(?string $value): self;
}
