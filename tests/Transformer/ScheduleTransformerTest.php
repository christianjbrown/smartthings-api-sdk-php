<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Schedule;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Schedule::class)]
#[CoversClass(ScheduleTransformer::class)]
final class ScheduleTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ScheduleTransformerInterface::KEY_NAME => 'test-schedule-name',
            ScheduleTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
        ];

        $transformer = new ScheduleTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-schedule-name', $actual->getName());
        self::assertSame('test-installed-app-id', $actual->getInstalledAppId());
    }

    /**
     * Exercises the optional installedAppId field in each of its three states:
     * absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedInstalledAppId): void
    {
        $transformer = new ScheduleTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-schedule-name', $actual->getName());
        self::assertSame($expectedInstalledAppId, $actual->getInstalledAppId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $installedAppIdStates = [
            'installedAppIdAbsent' => [null, null],
            'installedAppIdWrongType' => [42, null],
            'installedAppIdValid' => ['test-installed-app-id', 'test-installed-app-id'],
        ];

        foreach ($installedAppIdStates as $installedAppIdName => [$installedAppIdValue, $expectedInstalledAppId]) {
            $data = [ScheduleTransformerInterface::KEY_NAME => 'test-schedule-name'];
            if (null !== $installedAppIdValue) {
                $data[ScheduleTransformerInterface::KEY_INSTALLED_APP_ID] = $installedAppIdValue;
            }

            yield $installedAppIdName => [$data, $expectedInstalledAppId];
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ScheduleTransformerInterface::KEY_NAME => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ScheduleTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ScheduleTransformerInterface::UNEXPECTED_STRING_SPRINTF, ScheduleTransformerInterface::KEY_NAME));
        $transformer->transform($data);
    }
}
