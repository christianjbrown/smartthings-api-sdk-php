<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemComponentsItem;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemComponentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(GroupDeviceDetailsDevicesItemComponentsItem::class)]
#[CoversClass(GroupDeviceDetailsDevicesItemComponentsItemTransformer::class)]
final class GroupDeviceDetailsDevicesItemComponentsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::KEY_ID => 'test-id',
        ];

        $transformer = new GroupDeviceDetailsDevicesItemComponentsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-id', $actual->getId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new GroupDeviceDetailsDevicesItemComponentsItemTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'idAbsent' => [[], 'getId', null];
        yield 'idWrongType' => [[GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::KEY_ID => 42], 'getId', null];
        yield 'idValid' => [[GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface::KEY_ID => 'test-id'], 'getId', 'test-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new GroupDeviceDetailsDevicesItemComponentsItemTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getId());
    }
}
