<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityPresentation implements CapabilityPresentationInterface
{
    private ?AutomationForCapabilityInterface $automation = null;
    private ?DashboardForCapabilityInterface $dashboard = null;

    /**
     * @var array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    private array $detailView = [];
    private string $id;
    private ?PresentationSettingsInterface $presentationSettings = null;
    private ?int $version = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getAutomation(): ?AutomationForCapabilityInterface
    {
        return $this->automation;
    }

    public function getDashboard(): ?DashboardForCapabilityInterface
    {
        return $this->dashboard;
    }

    /**
     * @return array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    public function getDetailView(): array
    {
        return $this->detailView;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPresentationSettings(): ?PresentationSettingsInterface
    {
        return $this->presentationSettings;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setAutomation(?AutomationForCapabilityInterface $value): CapabilityPresentationInterface
    {
        $this->automation = $value;

        return $this;
    }

    public function setDashboard(?DashboardForCapabilityInterface $value): CapabilityPresentationInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    /**
     * @param array<int, CreateCapabilityPresentationRequestDetailViewItemInterface> $value
     */
    public function setDetailView(array $value): CapabilityPresentationInterface
    {
        $this->detailView = $value;

        return $this;
    }

    public function setId(string $value): CapabilityPresentationInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setPresentationSettings(?PresentationSettingsInterface $value): CapabilityPresentationInterface
    {
        $this->presentationSettings = $value;

        return $this;
    }

    public function setVersion(?int $value): CapabilityPresentationInterface
    {
        $this->version = $value;

        return $this;
    }
}
