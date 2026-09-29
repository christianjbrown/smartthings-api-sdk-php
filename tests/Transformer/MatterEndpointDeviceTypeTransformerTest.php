<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\MatterEndpointDeviceType;
use ChristianBrown\SmartThings\Transformer\MatterEndpointDeviceTypeTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointDeviceTypeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MatterEndpointDeviceType::class)]
#[CoversClass(MatterEndpointDeviceTypeTransformer::class)]
final class MatterEndpointDeviceTypeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            MatterEndpointDeviceTypeTransformerInterface::KEY_DEVICE_TYPE_ID => 1.5,
        ];

        $transformer = new MatterEndpointDeviceTypeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1.5, $actual->getDeviceTypeId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new MatterEndpointDeviceTypeTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'deviceTypeIdAbsent' => [[], 'getDeviceTypeId', null];
        yield 'deviceTypeIdWrongType' => [[MatterEndpointDeviceTypeTransformerInterface::KEY_DEVICE_TYPE_ID => 'not-number'], 'getDeviceTypeId', null];
        yield 'deviceTypeIdValid' => [[MatterEndpointDeviceTypeTransformerInterface::KEY_DEVICE_TYPE_ID => 1.5], 'getDeviceTypeId', 1.5];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new MatterEndpointDeviceTypeTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDeviceTypeId());
    }
}
