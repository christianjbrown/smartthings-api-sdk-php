<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItem;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItem::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemTransformer::class)]
final class DeviceConfigEntryForDashboardStateFormatInfoItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemTimeModel);
        $data = [
            DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_KEY => 'test-key',
            DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TYPE => 'test-type',
            DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_REMAINING_TIME => ['test-nested'],
            DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TIME => ['test-nested'],
        ];

        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTransformer($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-key', $actual->getKey());
        self::assertSame('test-type', $actual->getType());
        self::assertSame($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel, $actual->getRemainingTime());
        self::assertSame($deviceConfigEntryForDashboardStateFormatInfoItemTimeModel, $actual->getTime());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTransformer(self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::class), self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'keyAbsent' => [[DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TYPE => 'test-type'], 'getKey', null];
        yield 'keyWrongType' => [[DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TYPE => 'test-type', DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_KEY => 42], 'getKey', null];
        yield 'typeAbsent' => [[DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_KEY => 'test-key'], 'getType', null];
        yield 'typeWrongType' => [[DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_KEY => 'test-key', DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TYPE => 42], 'getType', null];
    }

    public function testTransformRemainingTime(): void
    {
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemTimeModel);
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTransformer($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer);
        $base = [DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_KEY => 'test-key', DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TYPE => 'test-type'];

        self::assertNull($transformer->transform($base)->getRemainingTime());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_REMAINING_TIME => 'test-not-array'])->getRemainingTime());
        self::assertSame($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel, $transformer->transform($base + [DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_REMAINING_TIME => ['test-nested']])->getRemainingTime());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemTimeModel);
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTransformer($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer);

        $actual = $transformer->transform([DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_KEY => 'test-key', DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TYPE => 'test-type']);

        self::assertNull($actual->getRemainingTime());
        self::assertNull($actual->getTime());
    }

    public function testTransformTime(): void
    {
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemTimeModel);
        $transformer = new DeviceConfigEntryForDashboardStateFormatInfoItemTransformer($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer);
        $base = [DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_KEY => 'test-key', DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TYPE => 'test-type'];

        self::assertNull($transformer->transform($base)->getTime());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TIME => 'test-not-array'])->getTime());
        self::assertSame($deviceConfigEntryForDashboardStateFormatInfoItemTimeModel, $transformer->transform($base + [DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::KEY_TIME => ['test-nested']])->getTime());
    }
}
