<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateCapabilityPresentationRequest implements CreateCapabilityPresentationRequestInterface
{
    private ?AutomationForCapabilityInterface $automation = null;
    private ?DashboardForCapabilityInterface $dashboard = null;

    /**
     * @var null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    private ?array $detailView = null;
    private string $id;
    private ?PresentationSettingsInterface $presentationSettings = null;
    private int $version;

    public function __construct(string $id, int $version)
    {
        $this->id = $id;
        $this->version = $version;
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
     * @return null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    public function getDetailView(): ?array
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

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setAutomation(?AutomationForCapabilityInterface $value): CreateCapabilityPresentationRequestInterface
    {
        $this->automation = $value;

        return $this;
    }

    public function setDashboard(?DashboardForCapabilityInterface $value): CreateCapabilityPresentationRequestInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    /**
     * @param null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface> $value
     */
    public function setDetailView(?array $value): CreateCapabilityPresentationRequestInterface
    {
        $this->detailView = $value;

        return $this;
    }

    public function setPresentationSettings(?PresentationSettingsInterface $value): CreateCapabilityPresentationRequestInterface
    {
        $this->presentationSettings = $value;

        return $this;
    }
}
