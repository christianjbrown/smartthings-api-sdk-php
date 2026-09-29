<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityPresentationInterface
{
    public function getAutomation(): ?AutomationForCapabilityInterface;

    public function getDashboard(): ?DashboardForCapabilityInterface;

    /**
     * @return array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    public function getDetailView(): array;

    public function getId(): string;

    public function getPresentationSettings(): ?PresentationSettingsInterface;

    public function getVersion(): ?int;

    public function setAutomation(?AutomationForCapabilityInterface $value): self;

    public function setDashboard(?DashboardForCapabilityInterface $value): self;

    /**
     * @param array<int, CreateCapabilityPresentationRequestDetailViewItemInterface> $value
     */
    public function setDetailView(array $value): self;

    public function setId(string $value): self;

    public function setPresentationSettings(?PresentationSettingsInterface $value): self;

    public function setVersion(?int $value): self;
}
