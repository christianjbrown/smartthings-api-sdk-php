<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CronScheduleInterface;
use ChristianBrown\SmartThings\Model\Schedule;
use ChristianBrown\SmartThings\Model\ScheduleDetailsInterface;
use ChristianBrown\SmartThings\Transformer\ScheduleDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Schedule::class)]
#[CoversClass(ScheduleTransformer::class)]
final class ScheduleTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ScheduleTransformer(self::createStub(ScheduleDetailsTransformerInterface::class));

        $actual = $transformer->transform([ScheduleTransformerInterface::KEY_NAME => 'test-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'locationIdAbsent' => [[], 'getLocationId', null];
        yield 'locationIdWrongType' => [[ScheduleTransformerInterface::KEY_LOCATION_ID => 42], 'getLocationId', null];
        yield 'locationIdValid' => [[ScheduleTransformerInterface::KEY_LOCATION_ID => 'test-location-id'], 'getLocationId', 'test-location-id'];
        yield 'userUuidAbsent' => [[], 'getUserUuid', null];
        yield 'userUuidWrongType' => [[ScheduleTransformerInterface::KEY_USER_UUID => 42], 'getUserUuid', null];
        yield 'userUuidValid' => [[ScheduleTransformerInterface::KEY_USER_UUID => 'test-user-uuid'], 'getUserUuid', 'test-user-uuid'];
        yield 'scheduledExecutionsAbsent' => [[], 'getScheduledExecutions', []];
        yield 'scheduledExecutionsWrongType' => [[ScheduleTransformerInterface::KEY_SCHEDULED_EXECUTIONS => 'not-array'], 'getScheduledExecutions', []];
        yield 'scheduledExecutionsValid' => [[ScheduleTransformerInterface::KEY_SCHEDULED_EXECUTIONS => [1, 'x', 2]], 'getScheduledExecutions', [1, 2]];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $cron = self::createStub(CronScheduleInterface::class);
        $details = self::createStub(ScheduleDetailsInterface::class);
        $details->method('getCron')->willReturn($cron);

        $data = [ScheduleTransformerInterface::KEY_NAME => 'test-name'] + [ScheduleTransformerInterface::KEY_CRON => []];
        $containerTransformer = self::createMock(ScheduleDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new ScheduleTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($cron, $actual->getCron());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(ScheduleDetailsInterface::class);
        $containerTransformer = self::createStub(ScheduleDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new ScheduleTransformer($containerTransformer);

        $actual = $transformer->transform([ScheduleTransformerInterface::KEY_NAME => 'test-name'] + [ScheduleTransformerInterface::KEY_CRON => []]);

        self::assertNull($actual->getCron());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(ScheduleDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new ScheduleTransformer($containerTransformer);

        $actual = $transformer->transform([ScheduleTransformerInterface::KEY_NAME => 'test-name']);

        self::assertNull($actual->getCron());
    }
}
