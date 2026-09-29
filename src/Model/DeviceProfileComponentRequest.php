<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceProfileComponentRequest implements DeviceProfileComponentRequestInterface
{
    /**
     * @var array<int, CapabilityReferenceRequestInterface>
     */
    private array $capabilities;

    /**
     * @var array<int, DeviceCategoryInterface>
     */
    private array $categories;
    private string $id;
    private ?string $label = null;
    private ?bool $optional = null;
    private ?RestrictionInterface $restrictions = null;

    /**
     * @phpstan-param array<int, CapabilityReferenceRequestInterface> $capabilities
     * @phpstan-param array<int, DeviceCategoryInterface> $categories
     */
    public function __construct(string $id, array $capabilities, array $categories)
    {
        $this->id = $id;
        $this->capabilities = $capabilities;
        $this->categories = $categories;
    }

    /**
     * @return array<int, CapabilityReferenceRequestInterface>
     */
    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    /**
     * @return array<int, DeviceCategoryInterface>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getOptional(): ?bool
    {
        return $this->optional;
    }

    public function getRestrictions(): ?RestrictionInterface
    {
        return $this->restrictions;
    }

    public function setLabel(?string $value): DeviceProfileComponentRequestInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setOptional(?bool $value): DeviceProfileComponentRequestInterface
    {
        $this->optional = $value;

        return $this;
    }

    public function setRestrictions(?RestrictionInterface $value): DeviceProfileComponentRequestInterface
    {
        $this->restrictions = $value;

        return $this;
    }
}
