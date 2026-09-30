<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedDeviceActionConfigEntry implements ExcludedDeviceActionConfigEntryInterface
{
    private ?string $capability;
    private ?string $component;

    /**
     * @var null|array<int, ExcludedActionItemIdInterface>
     */
    private ?array $exclusion = null;

    /**
     * @var null|array<int, PatchItemInterface>
     */
    private ?array $patch = null;

    /**
     * @var null|array<int, CapabilityValueInterface>
     */
    private ?array $values = null;
    private ?int $version = null;
    private ?VisibleConditionInterface $visibleCondition = null;

    public function __construct(?string $component, ?string $capability)
    {
        $this->component = $component;
        $this->capability = $capability;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    /**
     * @return null|array<int, ExcludedActionItemIdInterface>
     */
    public function getExclusion(): ?array
    {
        return $this->exclusion;
    }

    /**
     * @return null|array<int, PatchItemInterface>
     */
    public function getPatch(): ?array
    {
        return $this->patch;
    }

    /**
     * @return null|array<int, CapabilityValueInterface>
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionInterface
    {
        return $this->visibleCondition;
    }

    /**
     * @param null|array<int, ExcludedActionItemIdInterface> $value
     */
    public function setExclusion(?array $value): ExcludedDeviceActionConfigEntryInterface
    {
        $this->exclusion = $value;

        return $this;
    }

    /**
     * @param null|array<int, PatchItemInterface> $value
     */
    public function setPatch(?array $value): ExcludedDeviceActionConfigEntryInterface
    {
        $this->patch = $value;

        return $this;
    }

    /**
     * @param null|array<int, CapabilityValueInterface> $value
     */
    public function setValues(?array $value): ExcludedDeviceActionConfigEntryInterface
    {
        $this->values = $value;

        return $this;
    }

    public function setVersion(?int $value): ExcludedDeviceActionConfigEntryInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionInterface $value): ExcludedDeviceActionConfigEntryInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
