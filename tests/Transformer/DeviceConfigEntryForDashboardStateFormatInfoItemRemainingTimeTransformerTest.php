<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer::class)]
final class DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::KEY_TIME_FORMAT => 'test-time-format',
            DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::KEY_FREQUENCY => 7,
        ];

        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-time-format', $actual->getTimeFormat());
        self::assertSame(7, $actual->getFrequency());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'timeFormatAbsent' => [[], 'getTimeFormat', null];
        yield 'timeFormatWrongType' => [[DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::KEY_TIME_FORMAT => 42], 'getTimeFormat', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer();

        $actual = $transformer->transform([DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::KEY_TIME_FORMAT => 'test-time-format'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'frequencyAbsent' => [[], 'getFrequency', null];
        yield 'frequencyWrongType' => [[DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::KEY_FREQUENCY => 'not-int'], 'getFrequency', null];
        yield 'frequencyValid' => [[DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::KEY_FREQUENCY => 7], 'getFrequency', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer();

        $actual = $transformer->transform([DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::KEY_TIME_FORMAT => 'test-time-format']);

        self::assertNull($actual->getFrequency());
    }
}
