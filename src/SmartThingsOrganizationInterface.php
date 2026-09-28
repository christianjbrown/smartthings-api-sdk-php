<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\OrganizationApiInterface;
use ChristianBrown\SmartThings\Api\ServiceApiInterface;

interface SmartThingsOrganizationInterface
{
    public function getOrganizationApi(): OrganizationApiInterface;

    public function getServiceApi(): ServiceApiInterface;
}
