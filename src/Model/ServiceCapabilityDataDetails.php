<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceCapabilityDataDetails implements ServiceCapabilityDataDetailsInterface
{
    /**
     * @var null|array<int, ServiceCapabilityDataAlertItemInterface>
     */
    private ?array $alert = null;

    /**
     * @return null|array<int, ServiceCapabilityDataAlertItemInterface>
     */
    public function getAlert(): ?array
    {
        return $this->alert;
    }

    /**
     * @param null|array<int, ServiceCapabilityDataAlertItemInterface> $value
     */
    public function setAlert(?array $value): ServiceCapabilityDataDetailsInterface
    {
        $this->alert = $value;

        return $this;
    }
}
