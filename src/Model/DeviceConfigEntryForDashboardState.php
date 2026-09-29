<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigEntryForDashboardState implements DeviceConfigEntryForDashboardStateInterface
{
    private string $capability;
    private string $component;
    private ?bool $composite = null;

    /**
     * @var null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    private ?array $formatInfo = null;
    private ?string $group = null;
    private ?int $idx = null;

    /**
     * @var null|array<int, CapabilityValueForDashboardStateInterface>
     */
    private ?array $values = null;
    private ?int $version = null;
    private ?VisibleConditionForDashboardStateInterface $visibleCondition = null;

    public function __construct(string $component, string $capability)
    {
        $this->component = $component;
        $this->capability = $capability;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function getComposite(): ?bool
    {
        return $this->composite;
    }

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    public function getFormatInfo(): ?array
    {
        return $this->formatInfo;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getIdx(): ?int
    {
        return $this->idx;
    }

    /**
     * @return null|array<int, CapabilityValueForDashboardStateInterface>
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionForDashboardStateInterface
    {
        return $this->visibleCondition;
    }

    public function setComposite(?bool $value): DeviceConfigEntryForDashboardStateInterface
    {
        $this->composite = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $value
     */
    public function setFormatInfo(?array $value): DeviceConfigEntryForDashboardStateInterface
    {
        $this->formatInfo = $value;

        return $this;
    }

    public function setGroup(?string $value): DeviceConfigEntryForDashboardStateInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setIdx(?int $value): DeviceConfigEntryForDashboardStateInterface
    {
        $this->idx = $value;

        return $this;
    }

    /**
     * @param null|array<int, CapabilityValueForDashboardStateInterface> $value
     */
    public function setValues(?array $value): DeviceConfigEntryForDashboardStateInterface
    {
        $this->values = $value;

        return $this;
    }

    public function setVersion(?int $value): DeviceConfigEntryForDashboardStateInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionForDashboardStateInterface $value): DeviceConfigEntryForDashboardStateInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
