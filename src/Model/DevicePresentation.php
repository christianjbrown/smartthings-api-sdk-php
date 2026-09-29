<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DevicePresentation implements DevicePresentationInterface
{
    private ?AutomationInterface $automation = null;
    private ?DashboardInterface $dashboard = null;
    private ?string $description = null;

    /**
     * @var null|array<int, DetailViewListItemInterface>
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

    /**
     * @var null|array<int, LanguageItemInterface>
     */
    private ?array $language = null;
    private ?string $manufacturerName = null;
    private string $mnmn;
    private ?string $presentationId = null;
    private ?PresentationSettingsForDevicePresentationInterface $presentationSettings = null;
    private ?string $version = null;
    private string $vid;

    public function __construct(string $mnmn, string $vid)
    {
        $this->mnmn = $mnmn;
        $this->vid = $vid;
    }

    public function getAutomation(): ?AutomationInterface
    {
        return $this->automation;
    }

    public function getDashboard(): ?DashboardInterface
    {
        return $this->dashboard;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return null|array<int, DetailViewListItemInterface>
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

    /**
     * @return null|array<int, LanguageItemInterface>
     */
    public function getLanguage(): ?array
    {
        return $this->language;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function getMnmn(): string
    {
        return $this->mnmn;
    }

    public function getPresentationId(): ?string
    {
        return $this->presentationId;
    }

    public function getPresentationSettings(): ?PresentationSettingsForDevicePresentationInterface
    {
        return $this->presentationSettings;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function getVid(): string
    {
        return $this->vid;
    }

    public function setAutomation(?AutomationInterface $value): DevicePresentationInterface
    {
        $this->automation = $value;

        return $this;
    }

    public function setDashboard(?DashboardInterface $value): DevicePresentationInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    public function setDescription(?string $value): DevicePresentationInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param null|array<int, DetailViewListItemInterface> $value
     */
    public function setDetailView(?array $value): DevicePresentationInterface
    {
        $this->detailView = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationDpInfoItemInterface> $value
     */
    public function setDpInfo(?array $value): DevicePresentationInterface
    {
        $this->dpInfo = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationDpInfosItemInterface> $value
     */
    public function setDpInfos(?array $value): DevicePresentationInterface
    {
        $this->dpInfos = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemInterface> $value
     */
    public function setIcons(?array $value): DevicePresentationInterface
    {
        $this->icons = $value;

        return $this;
    }

    public function setIconUrl(?string $value): DevicePresentationInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    /**
     * @param null|array<int, LanguageItemInterface> $value
     */
    public function setLanguage(?array $value): DevicePresentationInterface
    {
        $this->language = $value;

        return $this;
    }

    public function setManufacturerName(?string $value): DevicePresentationInterface
    {
        $this->manufacturerName = $value;

        return $this;
    }

    public function setPresentationId(?string $value): DevicePresentationInterface
    {
        $this->presentationId = $value;

        return $this;
    }

    public function setPresentationSettings(?PresentationSettingsForDevicePresentationInterface $value): DevicePresentationInterface
    {
        $this->presentationSettings = $value;

        return $this;
    }

    public function setVersion(?string $value): DevicePresentationInterface
    {
        $this->version = $value;

        return $this;
    }
}
