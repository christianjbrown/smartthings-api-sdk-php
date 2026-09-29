<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTime;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'timeFormatAbsent' => [[], sprintf(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::KEY_TIME_FORMAT)];
        yield 'timeFormatWrongType' => [[DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::KEY_TIME_FORMAT => 42], sprintf(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::KEY_TIME_FORMAT)];
    }
}
