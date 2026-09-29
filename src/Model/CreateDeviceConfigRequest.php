<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateDeviceConfigRequest implements CreateDeviceConfigRequestInterface
{
    private ?DeviceConfigurationRequestAutomationInterface $automation = null;
    private ?DeviceConfigurationDashboardInterface $dashboard = null;

    /**
     * @var null|array<int, DeviceConfigEntryForDetailViewInterface>
     */
    private ?array $detailView = null;

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

    public function setAutomation(?DeviceConfigurationRequestAutomationInterface $value): CreateDeviceConfigRequestInterface
    {
        $this->automation = $value;

        return $this;
    }

    public function setDashboard(?DeviceConfigurationDashboardInterface $value): CreateDeviceConfigRequestInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDetailViewInterface> $value
     */
    public function setDetailView(?array $value): CreateDeviceConfigRequestInterface
    {
        $this->detailView = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemInterface> $value
     */
    public function setIcons(?array $value): CreateDeviceConfigRequestInterface
    {
        $this->icons = $value;

        return $this;
    }

    public function setIconUrl(?string $value): CreateDeviceConfigRequestInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setType(?string $value): CreateDeviceConfigRequestInterface
    {
        $this->type = $value;

        return $this;
    }
}
