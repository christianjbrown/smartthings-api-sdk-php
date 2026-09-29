<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StatesArrayItem implements StatesArrayItemInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private string $capability;
    private string $component;
    private ?bool $composite = null;

    /**
     * @var null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    private ?array $formatInfo = null;
    private ?string $group = null;
    private string $label;
    private ?bool $transient = null;
    private ?int $version = null;
    private ?VisibleConditionForDashboardStateInterface $visibleCondition = null;

    public function __construct(string $label, string $capability, string $component)
    {
        $this->label = $label;
        $this->capability = $capability;
        $this->component = $component;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
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

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getTransient(): ?bool
    {
        return $this->transient;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionForDashboardStateInterface
    {
        return $this->visibleCondition;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): StatesArrayItemInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setComposite(?bool $value): StatesArrayItemInterface
    {
        $this->composite = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $value
     */
    public function setFormatInfo(?array $value): StatesArrayItemInterface
    {
        $this->formatInfo = $value;

        return $this;
    }

    public function setGroup(?string $value): StatesArrayItemInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setTransient(?bool $value): StatesArrayItemInterface
    {
        $this->transient = $value;

        return $this;
    }

    public function setVersion(?int $value): StatesArrayItemInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionForDashboardStateInterface $value): StatesArrayItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
