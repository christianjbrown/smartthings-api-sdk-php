<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CronSchedule;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CronSchedule::class)]
#[CoversClass(CronScheduleTransformer::class)]
final class CronScheduleTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CronScheduleTransformerInterface::KEY_EXPRESSION => 'test-expression',
            CronScheduleTransformerInterface::KEY_TIMEZONE => 'test-timezone',
        ];

        $transformer = new CronScheduleTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-expression', $actual->getExpression());
        self::assertSame('test-timezone', $actual->getTimezone());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CronScheduleTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'expressionAbsent' => [[CronScheduleTransformerInterface::KEY_TIMEZONE => 'test-timezone'], 'getExpression', null];
        yield 'expressionWrongType' => [[CronScheduleTransformerInterface::KEY_TIMEZONE => 'test-timezone', CronScheduleTransformerInterface::KEY_EXPRESSION => 42], 'getExpression', null];
        yield 'timezoneAbsent' => [[CronScheduleTransformerInterface::KEY_EXPRESSION => 'test-expression'], 'getTimezone', null];
        yield 'timezoneWrongType' => [[CronScheduleTransformerInterface::KEY_EXPRESSION => 'test-expression', CronScheduleTransformerInterface::KEY_TIMEZONE => 42], 'getTimezone', null];
    }
}
