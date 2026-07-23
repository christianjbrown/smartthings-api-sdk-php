<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHealth;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function strtotime;

#[CoversClass(DeviceHealth::class)]
#[CoversClass(DeviceHealthTransformer::class)]
final class DeviceHealthTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceHealthTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            DeviceHealthTransformerInterface::KEY_LAST_UPDATED_DATE => '2021-01-15T12:00:00+0000',
            DeviceHealthTransformerInterface::KEY_STATE => 'ONLINE',
        ];

        $transformer = new DeviceHealthTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame(strtotime('2021-01-15T12:00:00+0000'), $actual->getLastUpdatedDate());
        self::assertSame('ONLINE', $actual->getState());
    }

    /**
     * Exercises the two optional fields across each of their states: the state
     * field (absent / wrong-type / valid) and the lastUpdatedDate field
     * (absent / wrong-type / unparseable-string / valid).
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?int $expectedLastUpdatedDate, ?string $expectedState): void
    {
        $transformer = new DeviceHealthTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame($expectedLastUpdatedDate, $actual->getLastUpdatedDate());
        self::assertSame($expectedState, $actual->getState());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?int, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $lastUpdatedDateStates = [
            'lastUpdatedDateAbsent' => [null, null],
            'lastUpdatedDateWrongType' => [42, null],
            'lastUpdatedDateUnparseable' => ['not-a-valid-date', null],
            'lastUpdatedDateValid' => ['2021-01-15T12:00:00+0000', strtotime('2021-01-15T12:00:00+0000')],
        ];
        $stateStates = [
            'stateAbsent' => [null, null],
            'stateWrongType' => [42, null],
            'stateValid' => ['ONLINE', 'ONLINE'],
        ];

        foreach ($lastUpdatedDateStates as $lastUpdatedDateName => [$lastUpdatedDateValue, $expectedLastUpdatedDate]) {
            foreach ($stateStates as $stateName => [$stateValue, $expectedState]) {
                $data = [DeviceHealthTransformerInterface::KEY_DEVICE_ID => 'test-device-id'];
                if (null !== $lastUpdatedDateValue) {
                    $data[DeviceHealthTransformerInterface::KEY_LAST_UPDATED_DATE] = $lastUpdatedDateValue;
                }
                if (null !== $stateValue) {
                    $data[DeviceHealthTransformerInterface::KEY_STATE] = $stateValue;
                }

                yield sprintf('%s, %s', $lastUpdatedDateName, $stateName) => [$data, $expectedLastUpdatedDate, $expectedState];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceHealthTransformerInterface::KEY_DEVICE_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new DeviceHealthTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceHealthTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceHealthTransformerInterface::KEY_DEVICE_ID));
        $transformer->transform($data);
    }
}
