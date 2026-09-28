<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceHealthDetail implements DeviceHealthDetailInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $deviceIds = null;
    private ?string $locationId = null;
    private ?string $subscriptionName = null;

    /**
     * @return null|array<int, string>
     */
    public function getDeviceIds(): ?array
    {
        return $this->deviceIds;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getSubscriptionName(): ?string
    {
        return $this->subscriptionName;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setDeviceIds(?array $value): DeviceHealthDetailInterface
    {
        $this->deviceIds = $value;

        return $this;
    }

    public function setLocationId(?string $value): DeviceHealthDetailInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setSubscriptionName(?string $value): DeviceHealthDetailInterface
    {
        $this->subscriptionName = $value;

        return $this;
    }
}
