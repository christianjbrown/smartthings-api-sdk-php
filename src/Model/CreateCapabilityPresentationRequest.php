<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateCapabilityPresentationRequest implements CreateCapabilityPresentationRequestInterface
{
    /**
     * @var null|mixed[]
     */
    private ?array $automation = null;

    /**
     * @var null|mixed[]
     */
    private ?array $dashboard = null;

    /**
     * @var null|mixed[]
     */
    private ?array $detailView = null;
    private string $id;

    /**
     * @var null|mixed[]
     */
    private ?array $presentationSettings = null;
    private ?int $version = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return null|mixed[]
     */
    public function getAutomation(): ?array
    {
        return $this->automation;
    }

    /**
     * @return null|mixed[]
     */
    public function getDashboard(): ?array
    {
        return $this->dashboard;
    }

    /**
     * @return null|mixed[]
     */
    public function getDetailView(): ?array
    {
        return $this->detailView;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return null|mixed[]
     */
    public function getPresentationSettings(): ?array
    {
        return $this->presentationSettings;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setAutomation(?array $value): CreateCapabilityPresentationRequestInterface
    {
        $this->automation = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setDashboard(?array $value): CreateCapabilityPresentationRequestInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setDetailView(?array $value): CreateCapabilityPresentationRequestInterface
    {
        $this->detailView = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setPresentationSettings(?array $value): CreateCapabilityPresentationRequestInterface
    {
        $this->presentationSettings = $value;

        return $this;
    }

    public function setVersion(?int $value): CreateCapabilityPresentationRequestInterface
    {
        $this->version = $value;

        return $this;
    }
}
