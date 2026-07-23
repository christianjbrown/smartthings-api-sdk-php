<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface OrganizationInterface
{
    public function getIsDefaultUserOrg(): ?bool;

    public function getLabel(): ?string;

    public function getManufacturerName(): ?string;

    public function getName(): ?string;

    public function getOrganizationId(): string;

    public function setIsDefaultUserOrg(?bool $value): self;

    public function setLabel(?string $value): self;

    public function setManufacturerName(?string $value): self;

    public function setName(?string $value): self;

    public function setOrganizationId(string $value): self;
}
