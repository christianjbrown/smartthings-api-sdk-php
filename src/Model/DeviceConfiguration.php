<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfiguration implements DeviceConfigurationInterface
{
    private ?DeviceConfigurationAutomationInterface $automation = null;
    private ?DeviceConfigurationDashboardInterface $dashboard = null;
    private ?string $description = null;

    /**
     * @var null|array<int, DeviceConfigEntryForDetailViewInterface>
     */
    private ?array $detailView = null;

    /**
     * @var null|array<int, DeviceConfigurationDpInfoItemInterface>
     */
    private ?array $dpInfo = null;

    /**
     * @var null|array<int, DeviceConfigurationDpInfosItemInterface>
     */
    private ?array $dpInfos = null;

    /**
     * @var null|array<int, DeviceConfigurationIconsItemInterface>
     */
    private ?array $icons = null;
    private ?string $iconUrl = null;
    private ?string $manufacturerName = null;
    private ?string $mnmn;
    private ?string $presentationId = null;
    private ?string $type = null;
    private ?string $version = null;
    private ?string $vid;

    public function __construct(?string $mnmn, ?string $vid)
    {
        $this->mnmn = $mnmn;
        $this->vid = $vid;
    }

    public function getAutomation(): ?DeviceConfigurationAutomationInterface
    {
        return $this->automation;
    }

    public function getDashboard(): ?DeviceConfigurationDashboardInterface
    {
        return $this->dashboard;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return null|array<int, DeviceConfigEntryForDetailViewInterface>
     */
    public function getDetailView(): ?array
    {
        return $this->detailView;
    }

    /**
     * @return null|array<int, DeviceConfigurationDpInfoItemInterface>
     */
    public function getDpInfo(): ?array
    {
        return $this->dpInfo;
    }

    /**
     * @return null|array<int, DeviceConfigurationDpInfosItemInterface>
     */
    public function getDpInfos(): ?array
    {
        return $this->dpInfos;
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

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function getMnmn(): ?string
    {
        return $this->mnmn;
    }

    public function getPresentationId(): ?string
    {
        return $this->presentationId;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function getVid(): ?string
    {
        return $this->vid;
    }

    public function setAutomation(?DeviceConfigurationAutomationInterface $value): DeviceConfigurationInterface
    {
        $this->automation = $value;

        return $this;
    }

    public function setDashboard(?DeviceConfigurationDashboardInterface $value): DeviceConfigurationInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    public function setDescription(?string $value): DeviceConfigurationInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDetailViewInterface> $value
     */
    public function setDetailView(?array $value): DeviceConfigurationInterface
    {
        $this->detailView = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationDpInfoItemInterface> $value
     */
    public function setDpInfo(?array $value): DeviceConfigurationInterface
    {
        $this->dpInfo = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationDpInfosItemInterface> $value
     */
    public function setDpInfos(?array $value): DeviceConfigurationInterface
    {
        $this->dpInfos = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemInterface> $value
     */
    public function setIcons(?array $value): DeviceConfigurationInterface
    {
        $this->icons = $value;

        return $this;
    }

    public function setIconUrl(?string $value): DeviceConfigurationInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setManufacturerName(?string $value): DeviceConfigurationInterface
    {
        $this->manufacturerName = $value;

        return $this;
    }

    public function setPresentationId(?string $value): DeviceConfigurationInterface
    {
        $this->presentationId = $value;

        return $this;
    }

    public function setType(?string $value): DeviceConfigurationInterface
    {
        $this->type = $value;

        return $this;
    }

    public function setVersion(?string $value): DeviceConfigurationInterface
    {
        $this->version = $value;

        return $this;
    }
}
