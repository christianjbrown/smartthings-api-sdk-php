<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceLocationInfoInterface
{
    public function getCity(): ?string;

    public function getLatitude(): ?float;

    public function getLocationId(): string;

    public function getLongitude(): ?float;

    /**
     * @return array<int, ServiceLocationInfoSubscriptionInterface>
     */
    public function getSubscriptions(): array;

    public function setCity(?string $value): self;

    public function setLatitude(?float $value): self;

    public function setLocationId(string $value): self;

    public function setLongitude(?float $value): self;

    /**
     * @param array<int, ServiceLocationInfoSubscriptionInterface> $value
     */
    public function setSubscriptions(array $value): self;
}
