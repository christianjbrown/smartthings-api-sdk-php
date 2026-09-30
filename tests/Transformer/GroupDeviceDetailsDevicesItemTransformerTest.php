<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItem;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemComponentsItemInterface;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(GroupDeviceDetailsDevicesItem::class)]
#[CoversClass(GroupDeviceDetailsDevicesItemTransformer::class)]
final class GroupDeviceDetailsDevicesItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $groupDeviceDetailsDevicesItemComponentsItemModel = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer->method('transform')->willReturn($groupDeviceDetailsDevicesItemComponentsItemModel);
        $data = [
            GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            GroupDeviceDetailsDevicesItemTransformerInterface::KEY_COMPONENTS => [['test-nested']],
        ];

        $transformer = new GroupDeviceDetailsDevicesItemTransformer($groupDeviceDetailsDevicesItemComponentsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame([$groupDeviceDetailsDevicesItemComponentsItemModel], $actual->getComponents());
    }

    public function testTransformComponents(): void
    {
        $groupDeviceDetailsDevicesItemComponentsItemModel = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer->method('transform')->willReturn($groupDeviceDetailsDevicesItemComponentsItemModel);
        $transformer = new GroupDeviceDetailsDevicesItemTransformer($groupDeviceDetailsDevicesItemComponentsItemTransformer);
        $base = [GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID => 'test-device-id'];

        self::assertNull($transformer->transform($base)->getComponents());
        self::assertNull($transformer->transform($base + [GroupDeviceDetailsDevicesItemTransformerInterface::KEY_COMPONENTS => 'test-not-array'])->getComponents());
        self::assertSame([$groupDeviceDetailsDevicesItemComponentsItemModel], $transformer->transform($base + [GroupDeviceDetailsDevicesItemTransformerInterface::KEY_COMPONENTS => [['test-nested'], 'test-skipped']])->getComponents());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new GroupDeviceDetailsDevicesItemTransformer(self::createStub(GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'deviceIdAbsent' => [[], 'getDeviceId', null];
        yield 'deviceIdWrongType' => [[GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID => 42], 'getDeviceId', null];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $groupDeviceDetailsDevicesItemComponentsItemModel = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer->method('transform')->willReturn($groupDeviceDetailsDevicesItemComponentsItemModel);
        $transformer = new GroupDeviceDetailsDevicesItemTransformer($groupDeviceDetailsDevicesItemComponentsItemTransformer);

        $actual = $transformer->transform([GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID => 'test-device-id']);

        self::assertNull($actual->getComponents());
    }
}
