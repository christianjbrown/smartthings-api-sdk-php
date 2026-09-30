<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTime;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemTime::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer::class)]
final class DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::KEY_TIME_FORMAT => 'test-time-format',
        ];

        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-time-format', $actual->getTimeFormat());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'timeFormatAbsent' => [[], 'getTimeFormat', null];
        yield 'timeFormatWrongType' => [[DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::KEY_TIME_FORMAT => 42], 'getTimeFormat', null];
    }
}
