<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceSubscriptionReceiptInterface
{
    public function getLocationId(): string;

    public function getSubscriptionId(): ?string;

    public function setLocationId(string $value): self;

    public function setSubscriptionId(?string $value): self;
}
