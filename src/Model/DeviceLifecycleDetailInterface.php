<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceLifecycleDetailInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getDeviceIds(): ?array;

    public function getLocationId(): ?string;

    public function getSubscriptionName(): ?string;

    /**
     * @param null|array<int, string> $value
     */
    public function setDeviceIds(?array $value): self;

    public function setLocationId(?string $value): self;

    public function setSubscriptionName(?string $value): self;
}
