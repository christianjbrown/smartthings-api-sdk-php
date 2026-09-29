<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ViperDeviceDetails;
use ChristianBrown\SmartThings\Transformer\ViperDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ViperDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ViperDeviceDetails::class)]
#[CoversClass(ViperDeviceDetailsTransformer::class)]
final class ViperDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ViperDeviceDetailsTransformerInterface::KEY_UNIQUE_IDENTIFIER => 'test-unique-identifier',
            ViperDeviceDetailsTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name',
            ViperDeviceDetailsTransformerInterface::KEY_MODEL_NAME => 'test-model-name',
            ViperDeviceDetailsTransformerInterface::KEY_SW_VERSION => 'test-sw-version',
            ViperDeviceDetailsTransformerInterface::KEY_HW_VERSION => 'test-hw-version',
            ViperDeviceDetailsTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
        ];

        $transformer = new ViperDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-unique-identifier', $actual->getUniqueIdentifier());
        self::assertSame('test-manufacturer-name', $actual->getManufacturerName());
        self::assertSame('test-model-name', $actual->getModelName());
        self::assertSame('test-sw-version', $actual->getSwVersion());
        self::assertSame('test-hw-version', $actual->getHwVersion());
        self::assertSame('test-endpoint-app-id', $actual->getEndpointAppId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ViperDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'uniqueIdentifierAbsent' => [[], 'getUniqueIdentifier', null];
        yield 'uniqueIdentifierWrongType' => [[ViperDeviceDetailsTransformerInterface::KEY_UNIQUE_IDENTIFIER => 42], 'getUniqueIdentifier', null];
        yield 'uniqueIdentifierValid' => [[ViperDeviceDetailsTransformerInterface::KEY_UNIQUE_IDENTIFIER => 'test-unique-identifier'], 'getUniqueIdentifier', 'test-unique-identifier'];
        yield 'manufacturerNameAbsent' => [[], 'getManufacturerName', null];
        yield 'manufacturerNameWrongType' => [[ViperDeviceDetailsTransformerInterface::KEY_MANUFACTURER_NAME => 42], 'getManufacturerName', null];
        yield 'manufacturerNameValid' => [[ViperDeviceDetailsTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name'], 'getManufacturerName', 'test-manufacturer-name'];
        yield 'modelNameAbsent' => [[], 'getModelName', null];
        yield 'modelNameWrongType' => [[ViperDeviceDetailsTransformerInterface::KEY_MODEL_NAME => 42], 'getModelName', null];
        yield 'modelNameValid' => [[ViperDeviceDetailsTransformerInterface::KEY_MODEL_NAME => 'test-model-name'], 'getModelName', 'test-model-name'];
        yield 'swVersionAbsent' => [[], 'getSwVersion', null];
        yield 'swVersionWrongType' => [[ViperDeviceDetailsTransformerInterface::KEY_SW_VERSION => 42], 'getSwVersion', null];
        yield 'swVersionValid' => [[ViperDeviceDetailsTransformerInterface::KEY_SW_VERSION => 'test-sw-version'], 'getSwVersion', 'test-sw-version'];
        yield 'hwVersionAbsent' => [[], 'getHwVersion', null];
        yield 'hwVersionWrongType' => [[ViperDeviceDetailsTransformerInterface::KEY_HW_VERSION => 42], 'getHwVersion', null];
        yield 'hwVersionValid' => [[ViperDeviceDetailsTransformerInterface::KEY_HW_VERSION => 'test-hw-version'], 'getHwVersion', 'test-hw-version'];
        yield 'endpointAppIdAbsent' => [[], 'getEndpointAppId', null];
        yield 'endpointAppIdWrongType' => [[ViperDeviceDetailsTransformerInterface::KEY_ENDPOINT_APP_ID => 42], 'getEndpointAppId', null];
        yield 'endpointAppIdValid' => [[ViperDeviceDetailsTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id'], 'getEndpointAppId', 'test-endpoint-app-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ViperDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getUniqueIdentifier());
        self::assertNull($actual->getManufacturerName());
        self::assertNull($actual->getModelName());
        self::assertNull($actual->getSwVersion());
        self::assertNull($actual->getHwVersion());
        self::assertNull($actual->getEndpointAppId());
    }
}
