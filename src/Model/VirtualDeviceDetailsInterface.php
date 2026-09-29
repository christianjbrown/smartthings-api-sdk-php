<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface VirtualDeviceDetailsInterface
{
    public function getCommandMappings(): ?CommandMappingsInterface;

    public function getDriverId(): ?string;

    public function getExecutingLocally(): ?bool;

    public function getHubId(): ?string;

    public function getName(): ?string;

    public function setCommandMappings(?CommandMappingsInterface $value): self;

    public function setDriverId(?string $value): self;

    public function setExecutingLocally(?bool $value): self;

    public function setHubId(?string $value): self;

    public function setName(?string $value): self;
}
