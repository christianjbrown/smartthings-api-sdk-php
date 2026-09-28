<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\ChannelApiInterface;
use ChristianBrown\SmartThings\Api\DriverApiInterface;
use ChristianBrown\SmartThings\Api\HubApiInterface;

interface SmartThingsEdgeInterface
{
    public function getChannelApi(): ChannelApiInterface;

    public function getDriverApi(): DriverApiInterface;

    public function getHubApi(): HubApiInterface;
}
