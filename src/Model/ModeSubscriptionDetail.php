<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ModeSubscriptionDetail implements ModeSubscriptionDetailInterface
{
    private string $locationId;

    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }
}
