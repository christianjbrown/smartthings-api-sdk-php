<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceProfileComponent implements DeviceProfileComponentInterface
{
    /**
     * @var array<int, DeviceCapabilityReferenceInterface>
     */
    private array $capabilities;

    /**
     * @var array<int, DeviceCategoryInterface>
     */
    private array $categories;
    private ?string $id;
    private ?string $label = null;
    private ?bool $optional = null;
    private ?RestrictionInterface $restrictions = null;

    /**
     * @phpstan-param array<int, DeviceCapabilityReferenceInterface> $capabilities
     * @phpstan-param array<int, DeviceCategoryInterface> $categories
     */
    public function __construct(?string $id, array $capabilities, array $categories)
    {
        $this->id = $id;
        $this->capabilities = $capabilities;
        $this->categories = $categories;
    }

    /**
     * @return array<int, DeviceCapabilityReferenceInterface>
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

    public function getId(): ?string
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

    public function setLabel(?string $value): DeviceProfileComponentInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setOptional(?bool $value): DeviceProfileComponentInterface
    {
        $this->optional = $value;

        return $this;
    }

    public function setRestrictions(?RestrictionInterface $value): DeviceProfileComponentInterface
    {
        $this->restrictions = $value;

        return $this;
    }
}
