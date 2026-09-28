<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

final class ApiHost implements ApiHostInterface
{
    private string $baseUrl;

    public function __construct(string $baseUrl = self::PRODUCTION_BASE_URL)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
