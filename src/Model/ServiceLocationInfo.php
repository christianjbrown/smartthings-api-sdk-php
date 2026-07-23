<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceLocationInfo implements ServiceLocationInfoInterface
{
    private ?string $city = null;
    private ?float $latitude = null;
    private string $locationId;
    private ?float $longitude = null;

    /**
     * @var array<int, ServiceLocationInfoSubscriptionInterface>
     */
    private array $subscriptions = [];

    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @return array<int, ServiceLocationInfoSubscriptionInterface>
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function setCity(?string $value): ServiceLocationInfoInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setLatitude(?float $value): ServiceLocationInfoInterface
    {
        $this->latitude = $value;

        return $this;
    }

    public function setLocationId(string $value): ServiceLocationInfoInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setLongitude(?float $value): ServiceLocationInfoInterface
    {
        $this->longitude = $value;

        return $this;
    }

    /**
     * @param array<int, ServiceLocationInfoSubscriptionInterface> $value
     */
    public function setSubscriptions(array $value): ServiceLocationInfoInterface
    {
        $this->subscriptions = $value;

        return $this;
    }
}
