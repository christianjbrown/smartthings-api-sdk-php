<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CronSchedule;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new CronScheduleTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'expressionAbsent' => [[CronScheduleTransformerInterface::KEY_TIMEZONE => 'test-timezone'], sprintf(CronScheduleTransformerInterface::UNEXPECTED_STRING_SPRINTF, CronScheduleTransformerInterface::KEY_EXPRESSION)];
        yield 'expressionWrongType' => [[CronScheduleTransformerInterface::KEY_TIMEZONE => 'test-timezone', CronScheduleTransformerInterface::KEY_EXPRESSION => 42], sprintf(CronScheduleTransformerInterface::UNEXPECTED_STRING_SPRINTF, CronScheduleTransformerInterface::KEY_EXPRESSION)];
        yield 'timezoneAbsent' => [[CronScheduleTransformerInterface::KEY_EXPRESSION => 'test-expression'], sprintf(CronScheduleTransformerInterface::UNEXPECTED_STRING_SPRINTF, CronScheduleTransformerInterface::KEY_TIMEZONE)];
        yield 'timezoneWrongType' => [[CronScheduleTransformerInterface::KEY_EXPRESSION => 'test-expression', CronScheduleTransformerInterface::KEY_TIMEZONE => 42], sprintf(CronScheduleTransformerInterface::UNEXPECTED_STRING_SPRINTF, CronScheduleTransformerInterface::KEY_TIMEZONE)];
    }
}
