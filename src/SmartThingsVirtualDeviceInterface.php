<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\SchemaAppOwnerApiInterface;
use ChristianBrown\SmartThings\Api\SchemaConnectorApiInterface;
use ChristianBrown\SmartThings\Api\VirtualDeviceApiInterface;

interface SmartThingsVirtualDeviceInterface
{
    public function getSchemaAppOwnerApi(): SchemaAppOwnerApiInterface;

    public function getSchemaConnectorApi(): SchemaConnectorApiInterface;

    public function getVirtualDeviceApi(): VirtualDeviceApiInterface;
}
