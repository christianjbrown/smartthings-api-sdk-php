<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\DevicePreference;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DevicePreference::class)]
final class DevicePreferenceTest extends TestCase
{
    public function test(): void
    {
        $preference = new DevicePreference('motionSensitivity');
        self::assertSame('motionSensitivity', $preference->getName());
        self::assertNull($preference->getPreferenceType());
        self::assertNull($preference->getValue());

        self::assertSame($preference, $preference->setName('tempOffset'));
        self::assertSame($preference, $preference->setPreferenceType('integer'));
        self::assertSame($preference, $preference->setValue(5));

        self::assertSame('tempOffset', $preference->getName());
        self::assertSame('integer', $preference->getPreferenceType());
        self::assertSame(5, $preference->getValue());
    }
}
