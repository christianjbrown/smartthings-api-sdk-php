<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DevicePresentationInterface
{
    public function getAutomation(): ?AutomationInterface;

    public function getDashboard(): ?DashboardInterface;

    public function getDescription(): ?string;

    /**
     * @return null|array<int, DetailViewListItemInterface>
     */
    public function getDetailView(): ?array;

    /**
     * @return null|array<int, DeviceConfigurationDpInfoItemInterface>
     */
    public function getDpInfo(): ?array;

    /**
     * @return null|array<int, DeviceConfigurationDpInfosItemInterface>
     */
    public function getDpInfos(): ?array;

    /**
     * @return null|array<int, DeviceConfigurationIconsItemInterface>
     */
    public function getIcons(): ?array;

    public function getIconUrl(): ?string;

    /**
     * @return null|array<int, LanguageItemInterface>
     */
    public function getLanguage(): ?array;

    public function getManufacturerName(): ?string;

    public function getMnmn(): ?string;

    public function getPresentationId(): ?string;

    public function getPresentationSettings(): ?PresentationSettingsForDevicePresentationInterface;

    public function getVersion(): ?string;

    public function getVid(): ?string;

    public function setAutomation(?AutomationInterface $value): self;

    public function setDashboard(?DashboardInterface $value): self;

    public function setDescription(?string $value): self;

    /**
     * @param null|array<int, DetailViewListItemInterface> $value
     */
    public function setDetailView(?array $value): self;

    /**
     * @param null|array<int, DeviceConfigurationDpInfoItemInterface> $value
     */
    public function setDpInfo(?array $value): self;

    /**
     * @param null|array<int, DeviceConfigurationDpInfosItemInterface> $value
     */
    public function setDpInfos(?array $value): self;

    /**
     * @param null|array<int, DeviceConfigurationIconsItemInterface> $value
     */
    public function setIcons(?array $value): self;

    public function setIconUrl(?string $value): self;

    /**
     * @param null|array<int, LanguageItemInterface> $value
     */
    public function setLanguage(?array $value): self;

    public function setManufacturerName(?string $value): self;

    public function setPresentationId(?string $value): self;

    public function setPresentationSettings(?PresentationSettingsForDevicePresentationInterface $value): self;

    public function setVersion(?string $value): self;
}
