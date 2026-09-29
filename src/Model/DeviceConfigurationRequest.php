<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationRequest implements DeviceConfigurationRequestInterface
{
    private ?DeviceConfigurationRequestAutomationInterface $automation = null;
    private ?DeviceConfigurationDashboardInterface $dashboard = null;

    /**
     * @var null|array<int, DeviceConfigEntryForDetailViewInterface>
     */
    private ?array $detailView = null;
    private ?string $deviceProfileId = null;

    /**
     * @var null|array<int, DeviceConfigurationIconsItemInterface>
     */
    private ?array $icons = null;
    private ?string $iconUrl = null;
    private ?string $type = null;

    public function getAutomation(): ?DeviceConfigurationRequestAutomationInterface
    {
        return $this->automation;
    }

    public function getDashboard(): ?DeviceConfigurationDashboardInterface
    {
        return $this->dashboard;
    }

    /**
     * @return null|array<int, DeviceConfigEntryForDetailViewInterface>
     */
    public function getDetailView(): ?array
    {
        return $this->detailView;
    }

    public function getDeviceProfileId(): ?string
    {
        return $this->deviceProfileId;
    }

    /**
     * @return null|array<int, DeviceConfigurationIconsItemInterface>
     */
    public function getIcons(): ?array
    {
        return $this->icons;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setAutomation(?DeviceConfigurationRequestAutomationInterface $value): DeviceConfigurationRequestInterface
    {
        $this->automation = $value;

        return $this;
    }

    public function setDashboard(?DeviceConfigurationDashboardInterface $value): DeviceConfigurationRequestInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDetailViewInterface> $value
     */
    public function setDetailView(?array $value): DeviceConfigurationRequestInterface
    {
        $this->detailView = $value;

        return $this;
    }

    public function setDeviceProfileId(?string $value): DeviceConfigurationRequestInterface
    {
        $this->deviceProfileId = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemInterface> $value
     */
    public function setIcons(?array $value): DeviceConfigurationRequestInterface
    {
        $this->icons = $value;

        return $this;
    }

    public function setIconUrl(?string $value): DeviceConfigurationRequestInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setType(?string $value): DeviceConfigurationRequestInterface
    {
        $this->type = $value;

        return $this;
    }
}
