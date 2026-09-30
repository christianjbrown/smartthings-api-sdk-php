<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SecurityArmStateDetail implements SecurityArmStateDetailInterface
{
    private ?string $locationId;
    private ?string $subscriptionName = null;

    public function __construct(?string $locationId)
    {
        $this->locationId = $locationId;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getSubscriptionName(): ?string
    {
        return $this->subscriptionName;
    }

    public function setSubscriptionName(?string $value): SecurityArmStateDetailInterface
    {
        $this->subscriptionName = $value;

        return $this;
    }
}
