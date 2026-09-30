<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedDeviceConditionConfigEntry implements ExcludedDeviceConditionConfigEntryInterface
{
    private ?string $capability;
    private ?string $component;

    /**
     * @var null|array<int, ExcludedConditionItemIdInterface>
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
     * @return null|array<int, ExcludedConditionItemIdInterface>
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
     * @param null|array<int, ExcludedConditionItemIdInterface> $value
     */
    public function setExclusion(?array $value): ExcludedDeviceConditionConfigEntryInterface
    {
        $this->exclusion = $value;

        return $this;
    }

    /**
     * @param null|array<int, PatchItemInterface> $value
     */
    public function setPatch(?array $value): ExcludedDeviceConditionConfigEntryInterface
    {
        $this->patch = $value;

        return $this;
    }

    /**
     * @param null|array<int, CapabilityValueInterface> $value
     */
    public function setValues(?array $value): ExcludedDeviceConditionConfigEntryInterface
    {
        $this->values = $value;

        return $this;
    }

    public function setVersion(?int $value): ExcludedDeviceConditionConfigEntryInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionInterface $value): ExcludedDeviceConditionConfigEntryInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
