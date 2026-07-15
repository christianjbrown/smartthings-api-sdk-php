<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Device;
use ChristianBrown\SmartThings\Model\DeviceComponentInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Device::class)]
#[CoversClass(DeviceTransformer::class)]
final class DeviceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $componentsData = ['test-component-1', 'test-component-2'];
        $data = [
            DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            DeviceTransformerInterface::KEY_LABEL => 'test-label',
            DeviceTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            DeviceTransformerInterface::KEY_NAME => 'test-name',
            DeviceTransformerInterface::KEY_ROOM_ID => 'test-room-id',
            DeviceTransformerInterface::KEY_COMPONENTS => $componentsData,
        ];

        $components = [
            self::createStub(DeviceComponentInterface::class),
            self::createStub(DeviceComponentInterface::class),
        ];

        $componentsTransformer = self::createMock(DeviceComponentsTransformerInterface::class);
        $componentsTransformer->method('transform')
            ->with($componentsData)
            ->willReturn($components);

        $transformer = new DeviceTransformer($componentsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($data[DeviceTransformerInterface::KEY_DEVICE_ID], $actual->getDeviceId());
        self::assertSame($data[DeviceTransformerInterface::KEY_LABEL], $actual->getLabel());
        self::assertSame($data[DeviceTransformerInterface::KEY_LOCATION_ID], $actual->getLocationId());
        self::assertSame($data[DeviceTransformerInterface::KEY_NAME], $actual->getName());
        self::assertSame($data[DeviceTransformerInterface::KEY_ROOM_ID], $actual->getRoomId());
        self::assertSame($components, $actual->getComponents());
    }

    /**
     * Exercises every combination of the five optional fields (label, locationId,
     * name, roomId, components), each in one of three states: absent,
     * present-but-wrong-type, or present-and-valid. This covers all paths through
     * the five optional blocks.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedLabel, ?string $expectedLocationId, ?string $expectedName, ?string $expectedRoomId, bool $expectComponents): void
    {
        $componentsData = $data[DeviceTransformerInterface::KEY_COMPONENTS] ?? null;
        $components = [self::createStub(DeviceComponentInterface::class)];

        $componentsTransformer = self::createMock(DeviceComponentsTransformerInterface::class);
        if ($expectComponents) {
            $componentsTransformer->expects(self::once())
                ->method('transform')
                ->with($componentsData)
                ->willReturn($components);
        } else {
            $componentsTransformer->expects(self::never())
                ->method('transform');
        }

        $transformer = new DeviceTransformer($componentsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame($expectedLabel, $actual->getLabel());
        self::assertSame($expectedLocationId, $actual->getLocationId());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedRoomId, $actual->getRoomId());
        self::assertSame($expectComponents ? $components : [], $actual->getComponents());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, bool}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        // state => [value to place in data (or null to omit), expected result]
        $labelStates = [
            'labelAbsent' => [null, null],
            'labelWrongType' => [42, null],
            'labelValid' => ['test-label', 'test-label'],
        ];
        $locationIdStates = [
            'locationIdAbsent' => [null, null],
            'locationIdWrongType' => [42, null],
            'locationIdValid' => ['test-location-id', 'test-location-id'],
        ];
        $nameStates = [
            'nameAbsent' => [null, null],
            'nameWrongType' => [42, null],
            'nameValid' => ['test-name', 'test-name'],
        ];
        $roomIdStates = [
            'roomIdAbsent' => [null, null],
            'roomIdWrongType' => [42, null],
            'roomIdValid' => ['test-room-id', 'test-room-id'],
        ];
        $componentsStates = [
            'componentsAbsent' => [null, false],
            'componentsWrongType' => ['not-array', false],
            'componentsValid' => [['test-component'], true],
        ];

        foreach ($labelStates as $labelName => [$labelValue, $expectedLabel]) {
            foreach ($locationIdStates as $locationIdName => [$locationIdValue, $expectedLocationId]) {
                foreach ($nameStates as $nameName => [$nameValue, $expectedName]) {
                    foreach ($roomIdStates as $roomIdName => [$roomIdValue, $expectedRoomId]) {
                        foreach ($componentsStates as $componentsName => [$componentsValue, $expectComponents]) {
                            $values = [
                                DeviceTransformerInterface::KEY_LABEL => $labelValue,
                                DeviceTransformerInterface::KEY_LOCATION_ID => $locationIdValue,
                                DeviceTransformerInterface::KEY_NAME => $nameValue,
                                DeviceTransformerInterface::KEY_ROOM_ID => $roomIdValue,
                                DeviceTransformerInterface::KEY_COMPONENTS => $componentsValue,
                            ];

                            yield sprintf('%s, %s, %s, %s, %s', $labelName, $locationIdName, $nameName, $roomIdName, $componentsName) => [
                                self::buildData($values),
                                $expectedLabel,
                                $expectedLocationId,
                                $expectedName,
                                $expectedRoomId,
                                $expectComponents,
                            ];
                        }
                    }
                }
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceTransformerInterface::KEY_DEVICE_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $componentsTransformer = self::createStub(DeviceComponentsTransformerInterface::class);
        $transformer = new DeviceTransformer($componentsTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceTransformerInterface::KEY_DEVICE_ID));
        $transformer->transform($data);
    }

    /**
     * Builds a transform payload from the given optional-field values, omitting
     * any whose value is null (the "absent" state).
     *
     * @param array<string, mixed> $values
     *
     * @return array<string, mixed>
     */
    private static function buildData(array $values): array
    {
        $data = [DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id'];
        foreach ($values as $key => $value) {
            if (null !== $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
