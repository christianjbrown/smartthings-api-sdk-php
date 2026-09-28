<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\PresentationApiInterface;

interface SmartThingsCapabilityInterface
{
    public function getCapabilityApi(): CapabilityApiInterface;

    public function getPresentationApi(): PresentationApiInterface;
}
