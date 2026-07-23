<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceLocationInfoSubscription implements ServiceLocationInfoSubscriptionInterface
{
    private ?string $predicate = null;

    /**
     * @var array<int, string>
     */
    private array $subscribedCapabilities = [];
    private string $subscriptionId;
    private ?string $type = null;

    public function __construct(string $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    public function getPredicate(): ?string
    {
        return $this->predicate;
    }

    /**
     * @return array<int, string>
     */
    public function getSubscribedCapabilities(): array
    {
        return $this->subscribedCapabilities;
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setPredicate(?string $value): ServiceLocationInfoSubscriptionInterface
    {
        $this->predicate = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setSubscribedCapabilities(array $value): ServiceLocationInfoSubscriptionInterface
    {
        $this->subscribedCapabilities = $value;

        return $this;
    }

    public function setSubscriptionId(string $value): ServiceLocationInfoSubscriptionInterface
    {
        $this->subscriptionId = $value;

        return $this;
    }

    public function setType(?string $value): ServiceLocationInfoSubscriptionInterface
    {
        $this->type = $value;

        return $this;
    }
}
