<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHistoryEvent;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceHistoryEvent::class)]
#[CoversClass(DeviceHistoryEventTransformer::class)]
final class DeviceHistoryEventTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceHistoryEventTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            DeviceHistoryEventTransformerInterface::KEY_ATTRIBUTE => 'switch',
            DeviceHistoryEventTransformerInterface::KEY_CAPABILITY => 'switch',
            DeviceHistoryEventTransformerInterface::KEY_COMPONENT => 'main',
            DeviceHistoryEventTransformerInterface::KEY_EPOCH => 1610712000000,
            DeviceHistoryEventTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            DeviceHistoryEventTransformerInterface::KEY_VALUE => 'on',
        ];

        $transformer = new DeviceHistoryEventTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame('switch', $actual->getAttribute());
        self::assertSame('switch', $actual->getCapability());
        self::assertSame('main', $actual->getComponent());
        self::assertSame(1610712000000, $actual->getEpoch());
        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('on', $actual->getValue());
    }

    public function testTransformAllOptionalsAbsent(): void
    {
        $transformer = new DeviceHistoryEventTransformer();

        $actual = $transformer->transform([DeviceHistoryEventTransformerInterface::KEY_DEVICE_ID => 'test-device-id']);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertNull($actual->getAttribute());
        self::assertNull($actual->getCapability());
        self::assertNull($actual->getComponent());
        self::assertNull($actual->getEpoch());
        self::assertNull($actual->getLocationId());
        self::assertNull($actual->getValue());
    }

    public function testTransformEpochWrongType(): void
    {
        $data = [
            DeviceHistoryEventTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            DeviceHistoryEventTransformerInterface::KEY_EPOCH => 'not-an-int',
        ];

        $transformer = new DeviceHistoryEventTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getEpoch());
    }

    /**
     * Each optional string field is silently skipped when present but not a string.
     */
    #[DataProvider('provideTransformOptionalStringFieldWrongTypeCases')]
    public function testTransformOptionalStringFieldWrongType(string $key): void
    {
        $data = [
            DeviceHistoryEventTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            $key => 42,
        ];

        $transformer = new DeviceHistoryEventTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertNull($actual->getAttribute());
        self::assertNull($actual->getCapability());
        self::assertNull($actual->getComponent());
        self::assertNull($actual->getLocationId());
        self::assertNull($actual->getValue());
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideTransformOptionalStringFieldWrongTypeCases(): iterable
    {
        yield 'attribute' => [DeviceHistoryEventTransformerInterface::KEY_ATTRIBUTE];
        yield 'capability' => [DeviceHistoryEventTransformerInterface::KEY_CAPABILITY];
        yield 'component' => [DeviceHistoryEventTransformerInterface::KEY_COMPONENT];
        yield 'locationId' => [DeviceHistoryEventTransformerInterface::KEY_LOCATION_ID];
        yield 'value' => [DeviceHistoryEventTransformerInterface::KEY_VALUE];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceHistoryEventTransformerInterface::KEY_DEVICE_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new DeviceHistoryEventTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceHistoryEventTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceHistoryEventTransformerInterface::KEY_DEVICE_ID));
        $transformer->transform($data);
    }
}
