<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CronSchedule;
use ChristianBrown\SmartThings\Model\OnceSchedule;
use ChristianBrown\SmartThings\Model\ScheduleRequest;
use ChristianBrown\SmartThings\Serializer\ScheduleRequestSerializer;
use ChristianBrown\SmartThings\Serializer\ScheduleRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CronSchedule::class)]
#[CoversClass(OnceSchedule::class)]
#[CoversClass(ScheduleRequest::class)]
#[CoversClass(ScheduleRequestSerializer::class)]
final class ScheduleRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new ScheduleRequest('test-name');

        $serializer = new ScheduleRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                ScheduleRequestSerializerInterface::KEY_NAME => 'test-name',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new ScheduleRequest('test-name'))
            ->setOnce((new OnceSchedule(7))
                ->setOverwrite(true))
            ->setCron(new CronSchedule('test-expression', 'test-timezone'));

        $serializer = new ScheduleRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                ScheduleRequestSerializerInterface::KEY_NAME => 'test-name',
                ScheduleRequestSerializerInterface::KEY_ONCE => [
                    ScheduleRequestSerializerInterface::KEY_TIME => 7,
                    ScheduleRequestSerializerInterface::KEY_OVERWRITE => true,
                ],
                ScheduleRequestSerializerInterface::KEY_CRON => [
                    ScheduleRequestSerializerInterface::KEY_EXPRESSION => 'test-expression',
                    ScheduleRequestSerializerInterface::KEY_TIMEZONE => 'test-timezone',
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithNestedOptionalsUnset(): void
    {
        $request = (new ScheduleRequest('test-name'))
            ->setOnce(new OnceSchedule(7))
            ->setCron(new CronSchedule('test-expression', 'test-timezone'));

        $serializer = new ScheduleRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                ScheduleRequestSerializerInterface::KEY_NAME => 'test-name',
                ScheduleRequestSerializerInterface::KEY_ONCE => [
                    ScheduleRequestSerializerInterface::KEY_TIME => 7,
                ],
                ScheduleRequestSerializerInterface::KEY_CRON => [
                    ScheduleRequestSerializerInterface::KEY_EXPRESSION => 'test-expression',
                    ScheduleRequestSerializerInterface::KEY_TIMEZONE => 'test-timezone',
                ],
            ],
            $actual
        );
    }
}
