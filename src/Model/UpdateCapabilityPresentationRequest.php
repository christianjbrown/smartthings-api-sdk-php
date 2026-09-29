<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateCapabilityPresentationRequest implements UpdateCapabilityPresentationRequestInterface
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

    /**
     * @var null|mixed[]
     */
    private ?array $presentationSettings = null;

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

    /**
     * @return null|mixed[]
     */
    public function getPresentationSettings(): ?array
    {
        return $this->presentationSettings;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setAutomation(?array $value): UpdateCapabilityPresentationRequestInterface
    {
        $this->automation = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setDashboard(?array $value): UpdateCapabilityPresentationRequestInterface
    {
        $this->dashboard = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setDetailView(?array $value): UpdateCapabilityPresentationRequestInterface
    {
        $this->detailView = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setPresentationSettings(?array $value): UpdateCapabilityPresentationRequestInterface
    {
        $this->presentationSettings = $value;

        return $this;
    }
}
