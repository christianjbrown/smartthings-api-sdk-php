<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DeviceProfile;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceProfile::class)]
final class DeviceProfileTest extends TestCase
{
    public function test(): void
    {
        $profile = new DeviceProfile('test-profile-id');
        self::assertSame('test-profile-id', $profile->getId());
        self::assertNull($profile->getName());
        self::assertNull($profile->getStatus());

        self::assertSame($profile, $profile->setId('test-new-profile-id'));
        self::assertSame($profile, $profile->setName('test-name'));
        self::assertSame($profile, $profile->setStatus('PUBLISHED'));

        self::assertSame('test-new-profile-id', $profile->getId());
        self::assertSame('test-name', $profile->getName());
        self::assertSame('PUBLISHED', $profile->getStatus());
    }
}
