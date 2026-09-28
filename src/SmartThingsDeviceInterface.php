<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;

interface SmartThingsDeviceInterface
{
    public function getDeviceApi(): DeviceApiInterface;

    public function getDeviceStatusApi(): DeviceStatusApiInterface;
}
