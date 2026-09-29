<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceCapabilityDataDetailsInterface
{
    /**
     * @return null|array<int, ServiceCapabilityDataAlertItemInterface>
     */
    public function getAlert(): ?array;

    /**
     * @param null|array<int, ServiceCapabilityDataAlertItemInterface> $value
     */
    public function setAlert(?array $value): self;
}
