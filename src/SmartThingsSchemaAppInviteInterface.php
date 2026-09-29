<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\SchemaAppInviteApiInterface;

interface SmartThingsSchemaAppInviteInterface
{
    public function getSchemaAppInviteApi(): SchemaAppInviteApiInterface;
}
