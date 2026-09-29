<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationInterface
{
    public function getAutomation(): ?DeviceConfigurationAutomationInterface;

    public function getDashboard(): ?DeviceConfigurationDashboardInterface;

    public function getDescription(): ?string;

    /**
     * @return null|array<int, DeviceConfigEntryForDetailViewInterface>
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

    public function getManufacturerName(): ?string;

    public function getMnmn(): string;

    public function getPresentationId(): ?string;

    public function getType(): ?string;

    public function getVersion(): ?string;

    public function getVid(): string;

    public function setAutomation(?DeviceConfigurationAutomationInterface $value): self;

    public function setDashboard(?DeviceConfigurationDashboardInterface $value): self;

    public function setDescription(?string $value): self;

    /**
     * @param null|array<int, DeviceConfigEntryForDetailViewInterface> $value
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

    public function setManufacturerName(?string $value): self;

    public function setPresentationId(?string $value): self;

    public function setType(?string $value): self;

    public function setVersion(?string $value): self;
}
