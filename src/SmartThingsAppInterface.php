<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\InstalledAppApiInterface;

interface SmartThingsAppInterface
{
    public function getAppApi(): AppApiInterface;

    public function getInstalledAppApi(): InstalledAppApiInterface;
}
