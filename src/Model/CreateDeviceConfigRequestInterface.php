<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateDeviceConfigRequestInterface
{
    public function getAutomation(): ?DeviceConfigurationRequestAutomationInterface;

    public function getDashboard(): ?DeviceConfigurationDashboardInterface;

    /**
     * @return null|array<int, DeviceConfigEntryForDetailViewInterface>
     */
    public function getDetailView(): ?array;

    /**
     * @return null|array<int, DeviceConfigurationIconsItemInterface>
     */
    public function getIcons(): ?array;

    public function getIconUrl(): ?string;

    public function getType(): ?string;

    public function setAutomation(?DeviceConfigurationRequestAutomationInterface $value): self;

    public function setDashboard(?DeviceConfigurationDashboardInterface $value): self;

    /**
     * @param null|array<int, DeviceConfigEntryForDetailViewInterface> $value
     */
    public function setDetailView(?array $value): self;

    /**
     * @param null|array<int, DeviceConfigurationIconsItemInterface> $value
     */
    public function setIcons(?array $value): self;

    public function setIconUrl(?string $value): self;

    public function setType(?string $value): self;
}
