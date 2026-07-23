<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHistoryEventInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceHistoryEventsTransformer::class)]
final class DeviceHistoryEventsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-event-1'], ['test-event-2']];

        $event1 = self::createStub(DeviceHistoryEventInterface::class);
        $event2 = self::createStub(DeviceHistoryEventInterface::class);
        $events = [$event1, $event2];

        $eventTransformer = self::createStub(DeviceHistoryEventTransformerInterface::class);
        $eventTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-event-1'], $event1],
                    [['test-event-2'], $event2],
                ]
            );

        $transformer = new DeviceHistoryEventsTransformer($eventTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($events, $actual);
    }

    public function testTransformEmpty(): void
    {
        $eventTransformer = self::createStub(DeviceHistoryEventTransformerInterface::class);

        $transformer = new DeviceHistoryEventsTransformer($eventTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $event1 = self::createStub(DeviceHistoryEventInterface::class);

        $eventTransformer = self::createMock(DeviceHistoryEventTransformerInterface::class);
        $eventTransformer->expects(self::once())->method('transform')
            ->with(['test-event-1'])
            ->willReturn($event1);

        $transformer = new DeviceHistoryEventsTransformer($eventTransformer);

        self::assertSame([$event1], $transformer->transform([['test-event-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $eventTransformer = self::createStub(DeviceHistoryEventTransformerInterface::class);

        $transformer = new DeviceHistoryEventsTransformer($eventTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceHistoryEventsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceHistoryEventsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-event-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-event-1-array'], 'test-event-2-not-array', ['test-event-3-array'], 'test-event-4-not-array'];

        $event1 = self::createStub(DeviceHistoryEventInterface::class);
        $event3 = self::createStub(DeviceHistoryEventInterface::class);

        $eventTransformer = self::createStub(DeviceHistoryEventTransformerInterface::class);
        $eventTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-event-1-array'], $event1],
                    [['test-event-3-array'], $event3],
                ]
            );

        $transformer = new DeviceHistoryEventsTransformer($eventTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceHistoryEventsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceHistoryEventsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
