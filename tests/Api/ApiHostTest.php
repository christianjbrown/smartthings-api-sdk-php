<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\SmartThings\Api\ApiHost;
use ChristianBrown\SmartThings\Api\ApiHostInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiHost::class)]
final class ApiHostTest extends TestCase
{
    public function testGetBaseUrlDefaultsToProduction(): void
    {
        $apiHost = new ApiHost();

        self::assertSame(ApiHostInterface::PRODUCTION_BASE_URL, $apiHost->getBaseUrl());
    }

    public function testGetBaseUrlReturnsOverride(): void
    {
        $apiHost = new ApiHost('https://staging.example.test');

        self::assertSame('https://staging.example.test', $apiHost->getBaseUrl());
    }
}
