<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceComponent implements DeviceComponentInterface
{
    /**
     * @var array<int, DeviceComponentCapabilityInterface>
     */
    private array $capabilities = [];

    /**
     * @var array<int, DeviceCategoryInterface>
     */
    private array $categories = [];
    private ?string $id = null;
    private ?string $label = null;
    private ?bool $optional = null;
    private ?RestrictionInterface $restrictions = null;

    /**
     * @return array<int, DeviceComponentCapabilityInterface>
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

    /**
     * @param array<int, DeviceComponentCapabilityInterface> $value
     */
    public function setCapabilities(array $value): DeviceComponentInterface
    {
        $this->capabilities = $value;

        return $this;
    }

    /**
     * @param array<int, DeviceCategoryInterface> $value
     */
    public function setCategories(array $value): DeviceComponentInterface
    {
        $this->categories = $value;

        return $this;
    }

    public function setId(?string $value): DeviceComponentInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setLabel(?string $value): DeviceComponentInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setOptional(?bool $value): DeviceComponentInterface
    {
        $this->optional = $value;

        return $this;
    }

    public function setRestrictions(?RestrictionInterface $value): DeviceComponentInterface
    {
        $this->restrictions = $value;

        return $this;
    }
}
