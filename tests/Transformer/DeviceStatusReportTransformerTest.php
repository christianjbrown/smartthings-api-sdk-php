<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ComponentStatusInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusReport;
use ChristianBrown\SmartThings\Model\IdLessHealthStateInterface;
use ChristianBrown\SmartThings\Transformer\ComponentStatusTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusReportTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusReportTransformerInterface;
use ChristianBrown\SmartThings\Transformer\IdLessHealthStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceStatusReportTransformer::class)]
#[CoversClass(DeviceStatusReport::class)]
#[CoversClass(ValueReader::class)]
final class DeviceStatusReportTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformReadsTheComponentsAndTheHealthState(): void
    {
        $mainStatus = self::createStub(ComponentStatusInterface::class);
        $componentStatusTransformer = self::createMock(ComponentStatusTransformerInterface::class);
        $componentStatusTransformer->expects(self::once())->method('transform')
            ->with(['switch' => ['switch' => ['value' => 'on']]])
            ->willReturn($mainStatus);
        $health = self::createStub(IdLessHealthStateInterface::class);
        $healthTransformer = self::createMock(IdLessHealthStateTransformerInterface::class);
        $healthTransformer->expects(self::once())->method('transform')
            ->with(['state' => 'ONLINE'])
            ->willReturn($health);

        $actual = (new DeviceStatusReportTransformer($componentStatusTransformer, $healthTransformer, new ValueReader()))->transform([
            DeviceStatusReportTransformerInterface::KEY_COMPONENTS => ['main' => ['switch' => ['switch' => ['value' => 'on']]], 'skipped' => 'not-an-array'],
            DeviceStatusReportTransformerInterface::KEY_HEALTH_STATE => ['state' => 'ONLINE'],
        ]);

        self::assertSame(['main' => $mainStatus], $actual->getComponents());
        self::assertSame($health, $actual->getHealthState());
    }

    /**
     * @throws Exception
     */
    public function testTransformToleratesMissingParts(): void
    {
        $actual = (new DeviceStatusReportTransformer(self::createStub(ComponentStatusTransformerInterface::class), self::createStub(IdLessHealthStateTransformerInterface::class), new ValueReader()))->transform([]);

        self::assertSame([], $actual->getComponents());
        self::assertNull($actual->getHealthState());
    }
}
