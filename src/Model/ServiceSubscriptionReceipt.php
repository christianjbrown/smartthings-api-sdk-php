<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceSubscriptionReceipt implements ServiceSubscriptionReceiptInterface
{
    private string $locationId;
    private ?string $subscriptionId = null;

    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    public function setLocationId(string $value): ServiceSubscriptionReceiptInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setSubscriptionId(?string $value): ServiceSubscriptionReceiptInterface
    {
        $this->subscriptionId = $value;

        return $this;
    }
}
