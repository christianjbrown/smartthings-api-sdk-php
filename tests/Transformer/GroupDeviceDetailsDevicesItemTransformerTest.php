<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItem;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemComponentsItemInterface;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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

    public function testTransformRequiredFieldsOnly(): void
    {
        $groupDeviceDetailsDevicesItemComponentsItemModel = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer = self::createStub(GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::class);
        $groupDeviceDetailsDevicesItemComponentsItemTransformer->method('transform')->willReturn($groupDeviceDetailsDevicesItemComponentsItemModel);
        $transformer = new GroupDeviceDetailsDevicesItemTransformer($groupDeviceDetailsDevicesItemComponentsItemTransformer);

        $actual = $transformer->transform([GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID => 'test-device-id']);

        self::assertNull($actual->getComponents());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new GroupDeviceDetailsDevicesItemTransformer(self::createStub(GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'deviceIdAbsent' => [[], sprintf(GroupDeviceDetailsDevicesItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID)];
        yield 'deviceIdWrongType' => [[GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID => 42], sprintf(GroupDeviceDetailsDevicesItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupDeviceDetailsDevicesItemTransformerInterface::KEY_DEVICE_ID)];
    }
}
