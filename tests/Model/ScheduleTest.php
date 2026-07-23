<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Schedule;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Schedule::class)]
final class ScheduleTest extends TestCase
{
    public function test(): void
    {
        $schedule = new Schedule('test-schedule-name');
        self::assertSame('test-schedule-name', $schedule->getName());
        self::assertNull($schedule->getInstalledAppId());

        self::assertSame($schedule, $schedule->setName('test-new-schedule-name'));
        self::assertSame($schedule, $schedule->setInstalledAppId('test-installed-app-id'));

        self::assertSame('test-new-schedule-name', $schedule->getName());
        self::assertSame('test-installed-app-id', $schedule->getInstalledAppId());
    }
}
