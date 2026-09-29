<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetails;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemInterface;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(GroupDeviceDetails::class)]
#[CoversClass(GroupDeviceDetailsTransformer::class)]
final class GroupDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $groupDeviceDetailsDevicesItemModel = self::createStub(GroupDeviceDetailsDevicesItemInterface::class);
        $groupDeviceDetailsDevicesItemTransformer = self::createStub(GroupDeviceDetailsDevicesItemTransformerInterface::class);
        $groupDeviceDetailsDevicesItemTransformer->method('transform')->willReturn($groupDeviceDetailsDevicesItemModel);
        $data = [
            GroupDeviceDetailsTransformerInterface::KEY_GROUP_NAME => 'test-group-name',
            GroupDeviceDetailsTransformerInterface::KEY_GROUP_TYPE => 'test-group-type',
            GroupDeviceDetailsTransformerInterface::KEY_DEVICES => [['test-nested']],
        ];

        $transformer = new GroupDeviceDetailsTransformer($groupDeviceDetailsDevicesItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-group-name', $actual->getGroupName());
        self::assertSame('test-group-type', $actual->getGroupType());
        self::assertSame([$groupDeviceDetailsDevicesItemModel], $actual->getDevices());
    }

    public function testTransformDevices(): void
    {
        $groupDeviceDetailsDevicesItemModel = self::createStub(GroupDeviceDetailsDevicesItemInterface::class);
        $groupDeviceDetailsDevicesItemTransformer = self::createStub(GroupDeviceDetailsDevicesItemTransformerInterface::class);
        $groupDeviceDetailsDevicesItemTransformer->method('transform')->willReturn($groupDeviceDetailsDevicesItemModel);
        $transformer = new GroupDeviceDetailsTransformer($groupDeviceDetailsDevicesItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDevices());
        self::assertNull($transformer->transform($base + [GroupDeviceDetailsTransformerInterface::KEY_DEVICES => 'test-not-array'])->getDevices());
        self::assertSame([$groupDeviceDetailsDevicesItemModel], $transformer->transform($base + [GroupDeviceDetailsTransformerInterface::KEY_DEVICES => [['test-nested'], 'test-skipped']])->getDevices());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new GroupDeviceDetailsTransformer(self::createStub(GroupDeviceDetailsDevicesItemTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'groupNameAbsent' => [[], 'getGroupName', null];
        yield 'groupNameWrongType' => [[GroupDeviceDetailsTransformerInterface::KEY_GROUP_NAME => 42], 'getGroupName', null];
        yield 'groupNameValid' => [[GroupDeviceDetailsTransformerInterface::KEY_GROUP_NAME => 'test-group-name'], 'getGroupName', 'test-group-name'];
        yield 'groupTypeAbsent' => [[], 'getGroupType', null];
        yield 'groupTypeWrongType' => [[GroupDeviceDetailsTransformerInterface::KEY_GROUP_TYPE => 42], 'getGroupType', null];
        yield 'groupTypeValid' => [[GroupDeviceDetailsTransformerInterface::KEY_GROUP_TYPE => 'test-group-type'], 'getGroupType', 'test-group-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $groupDeviceDetailsDevicesItemModel = self::createStub(GroupDeviceDetailsDevicesItemInterface::class);
        $groupDeviceDetailsDevicesItemTransformer = self::createStub(GroupDeviceDetailsDevicesItemTransformerInterface::class);
        $groupDeviceDetailsDevicesItemTransformer->method('transform')->willReturn($groupDeviceDetailsDevicesItemModel);
        $transformer = new GroupDeviceDetailsTransformer($groupDeviceDetailsDevicesItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getGroupName());
        self::assertNull($actual->getGroupType());
        self::assertNull($actual->getDevices());
    }
}
