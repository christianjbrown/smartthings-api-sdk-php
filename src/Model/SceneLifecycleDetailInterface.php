<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneLifecycleDetailInterface
{
    public function getLocationId(): ?string;

    public function getSubscriptionName(): ?string;

    public function setSubscriptionName(?string $value): self;
}
