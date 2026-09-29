<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityPresentationDetails implements CapabilityPresentationDetailsInterface
{
    private ?AutomationForCapabilityInterface $automation = null;
    private ?DashboardForCapabilityInterface $dashboard = null;

    /**
     * @var null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    private ?array $detailView = null;
    private ?PresentationSettingsInterface $presentationSettings = null;

    public function getAutomation(): ?AutomationForCapabilityInterface
    {
        return $this->automation;
    }

    public function getDashboard(): ?DashboardForCapabilityInterface
    {
        return $this->dashboard;
    }

    /**
     * @return null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    public function getDetailView(): ?array
    {
        return $this->detailView;
    }

    public function getPresentationSettings(): ?PresentationSettingsInterface
    {
        return $this->presentationSettings;
    }

    public function setAutomation(?AutomationForCapabilityInterface $value): CapabilityPresentationDetailsInterface
    {
        $this->automation = $value;

        return $this;
    }

    public function setDashboard(?DashboardForCapabilityInterface $value): CapabilityPresentationDetailsInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    /**
     * @param null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface> $value
     */
    public function setDetailView(?array $value): CapabilityPresentationDetailsInterface
    {
        $this->detailView = $value;

        return $this;
    }

    public function setPresentationSettings(?PresentationSettingsInterface $value): CapabilityPresentationDetailsInterface
    {
        $this->presentationSettings = $value;

        return $this;
    }
}
