<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItem;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemArgumentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationDpInfoItemArgumentsItem::class)]
#[CoversClass(DeviceConfigurationDpInfoItemArgumentsItemTransformer::class)]
final class DeviceConfigurationDpInfoItemArgumentsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 'test-key',
            DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new DeviceConfigurationDpInfoItemArgumentsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-key', $actual->getKey());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigurationDpInfoItemArgumentsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'keyAbsent' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 'test-value'], 'getKey', null];
        yield 'keyWrongType' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 'test-value', DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 42], 'getKey', null];
        yield 'valueAbsent' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 'test-key'], 'getValue', null];
        yield 'valueWrongType' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 'test-key', DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }
}
