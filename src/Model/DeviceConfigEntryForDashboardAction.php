<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigEntryForDashboardAction implements DeviceConfigEntryForDashboardActionInterface
{
    private ?string $capability;
    private ?string $component;
    private ?string $group = null;
    private ?int $idx = null;
    private ?DeviceConfigEntryForDashboardActionInlineInterface $inline = null;
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

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getIdx(): ?int
    {
        return $this->idx;
    }

    public function getInline(): ?DeviceConfigEntryForDashboardActionInlineInterface
    {
        return $this->inline;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionInterface
    {
        return $this->visibleCondition;
    }

    public function setGroup(?string $value): DeviceConfigEntryForDashboardActionInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setIdx(?int $value): DeviceConfigEntryForDashboardActionInterface
    {
        $this->idx = $value;

        return $this;
    }

    public function setInline(?DeviceConfigEntryForDashboardActionInlineInterface $value): DeviceConfigEntryForDashboardActionInterface
    {
        $this->inline = $value;

        return $this;
    }

    public function setVersion(?int $value): DeviceConfigEntryForDashboardActionInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionInterface $value): DeviceConfigEntryForDashboardActionInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
