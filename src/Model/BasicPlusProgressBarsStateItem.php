<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusProgressBarsStateItem implements BasicPlusProgressBarsStateItemInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $capability;
    private ?string $component;

    /**
     * @var null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    private ?array $formatInfo = null;
    private ?string $iconUrl = null;
    private ?string $label;
    private ?string $placement = null;
    private ?int $version = null;

    public function __construct(?string $label, ?string $capability, ?string $component)
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

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    public function getFormatInfo(): ?array
    {
        return $this->formatInfo;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getPlacement(): ?string
    {
        return $this->placement;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): BasicPlusProgressBarsStateItemInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $value
     */
    public function setFormatInfo(?array $value): BasicPlusProgressBarsStateItemInterface
    {
        $this->formatInfo = $value;

        return $this;
    }

    public function setIconUrl(?string $value): BasicPlusProgressBarsStateItemInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setPlacement(?string $value): BasicPlusProgressBarsStateItemInterface
    {
        $this->placement = $value;

        return $this;
    }

    public function setVersion(?int $value): BasicPlusProgressBarsStateItemInterface
    {
        $this->version = $value;

        return $this;
    }
}
