<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateCapabilityPresentationRequestInterface
{
    public function getAutomation(): ?AutomationForCapabilityInterface;

    public function getDashboard(): ?DashboardForCapabilityInterface;

    /**
     * @return null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    public function getDetailView(): ?array;

    public function getPresentationSettings(): ?PresentationSettingsInterface;

    public function setAutomation(?AutomationForCapabilityInterface $value): self;

    public function setDashboard(?DashboardForCapabilityInterface $value): self;

    /**
     * @param null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface> $value
     */
    public function setDetailView(?array $value): self;

    public function setPresentationSettings(?PresentationSettingsInterface $value): self;
}
