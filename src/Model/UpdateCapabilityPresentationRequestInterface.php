<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateCapabilityPresentationRequestInterface
{
    /**
     * @return null|mixed[]
     */
    public function getAutomation(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getDashboard(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getDetailView(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getPresentationSettings(): ?array;

    /**
     * @param null|mixed[] $value
     */
    public function setAutomation(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setDashboard(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setDetailView(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setPresentationSettings(?array $value): self;
}
