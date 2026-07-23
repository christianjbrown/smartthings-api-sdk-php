<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Organization implements OrganizationInterface
{
    private ?bool $isDefaultUserOrg = null;
    private ?string $label = null;
    private ?string $manufacturerName = null;
    private ?string $name = null;
    private string $organizationId;

    public function __construct(string $organizationId)
    {
        $this->organizationId = $organizationId;
    }

    public function getIsDefaultUserOrg(): ?bool
    {
        return $this->isDefaultUserOrg;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOrganizationId(): string
    {
        return $this->organizationId;
    }

    public function setIsDefaultUserOrg(?bool $value): OrganizationInterface
    {
        $this->isDefaultUserOrg = $value;

        return $this;
    }

    public function setLabel(?string $value): OrganizationInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setManufacturerName(?string $value): OrganizationInterface
    {
        $this->manufacturerName = $value;

        return $this;
    }

    public function setName(?string $value): OrganizationInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setOrganizationId(string $value): OrganizationInterface
    {
        $this->organizationId = $value;

        return $this;
    }
}
