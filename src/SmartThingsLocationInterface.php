<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;

interface SmartThingsLocationInterface
{
    public function getLocationApi(): LocationApiInterface;

    public function getLocationModeApi(): LocationModeApiInterface;

    public function getLocationRoomApi(): LocationRoomApiInterface;
}
