<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

interface ApiHostInterface
{
    public const string PRODUCTION_BASE_URL = 'https://api.smartthings.com';

    public function getBaseUrl(): string;
}
