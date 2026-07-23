<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ScheduleInterface;
use ChristianBrown\SmartThings\Transformer\SchedulesTransformer;
use ChristianBrown\SmartThings\Transformer\SchedulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchedulesTransformer::class)]
final class SchedulesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-schedule-1'], ['test-schedule-2']];

        $schedule1 = self::createStub(ScheduleInterface::class);
        $schedule2 = self::createStub(ScheduleInterface::class);
        $schedules = [$schedule1, $schedule2];

        $scheduleTransformer = self::createStub(ScheduleTransformerInterface::class);
        $scheduleTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-schedule-1'], $schedule1],
                    [['test-schedule-2'], $schedule2],
                ]
            );

        $transformer = new SchedulesTransformer($scheduleTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($schedules, $actual);
    }

    public function testTransformEmpty(): void
    {
        $scheduleTransformer = self::createStub(ScheduleTransformerInterface::class);

        $transformer = new SchedulesTransformer($scheduleTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $schedule1 = self::createStub(ScheduleInterface::class);

        $scheduleTransformer = self::createMock(ScheduleTransformerInterface::class);
        $scheduleTransformer->expects(self::once())->method('transform')
            ->with(['test-schedule-1'])
            ->willReturn($schedule1);

        $transformer = new SchedulesTransformer($scheduleTransformer);

        self::assertSame([$schedule1], $transformer->transform([['test-schedule-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $scheduleTransformer = self::createStub(ScheduleTransformerInterface::class);

        $transformer = new SchedulesTransformer($scheduleTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SchedulesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SchedulesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-schedule-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-schedule-1-array'], 'test-schedule-2-not-array', ['test-schedule-3-array'], 'test-schedule-4-not-array'];

        $schedule1 = self::createStub(ScheduleInterface::class);
        $schedule3 = self::createStub(ScheduleInterface::class);

        $scheduleTransformer = self::createStub(ScheduleTransformerInterface::class);
        $scheduleTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-schedule-1-array'], $schedule1],
                    [['test-schedule-3-array'], $schedule3],
                ]
            );

        $transformer = new SchedulesTransformer($scheduleTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SchedulesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SchedulesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
