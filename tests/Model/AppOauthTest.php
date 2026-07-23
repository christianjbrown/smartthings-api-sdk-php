<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\AppOauth;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppOauth::class)]
final class AppOauthTest extends TestCase
{
    public function test(): void
    {
        $oauth = new AppOauth();
        self::assertNull($oauth->getClientName());
        self::assertSame([], $oauth->getRedirectUris());
        self::assertSame([], $oauth->getScope());

        self::assertSame($oauth, $oauth->setClientName('test-client'));
        self::assertSame($oauth, $oauth->setRedirectUris(['https://example.test/callback']));
        self::assertSame($oauth, $oauth->setScope(['r:devices:*', 'x:devices:*']));

        self::assertSame('test-client', $oauth->getClientName());
        self::assertSame(['https://example.test/callback'], $oauth->getRedirectUris());
        self::assertSame(['r:devices:*', 'x:devices:*'], $oauth->getScope());
    }
}
