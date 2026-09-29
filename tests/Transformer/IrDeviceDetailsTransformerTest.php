<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\IrDeviceDetails;
use ChristianBrown\SmartThings\Model\IrDeviceDetailsFunctionCodesInterface;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsFunctionCodesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(IrDeviceDetails::class)]
#[CoversClass(IrDeviceDetailsTransformer::class)]
final class IrDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $irDeviceDetailsFunctionCodesModel = self::createStub(IrDeviceDetailsFunctionCodesInterface::class);
        $irDeviceDetailsFunctionCodesTransformer = self::createStub(IrDeviceDetailsFunctionCodesTransformerInterface::class);
        $irDeviceDetailsFunctionCodesTransformer->method('transform')->willReturn($irDeviceDetailsFunctionCodesModel);
        $data = [
            IrDeviceDetailsTransformerInterface::KEY_PARENT_DEVICE_ID => 'test-parent-device-id',
            IrDeviceDetailsTransformerInterface::KEY_PROFILE_ID => 'test-profile-id',
            IrDeviceDetailsTransformerInterface::KEY_OCF_DEVICE_TYPE => 'test-ocf-device-type',
            IrDeviceDetailsTransformerInterface::KEY_IR_CODE => 'test-ir-code',
            IrDeviceDetailsTransformerInterface::KEY_FUNCTION_CODES => ['test-nested'],
            IrDeviceDetailsTransformerInterface::KEY_CHILD_DEVICES => [[]],
            IrDeviceDetailsTransformerInterface::KEY_METADATA => ['test-metadata-key' => 'test-value'],
        ];

        $transformer = new IrDeviceDetailsTransformer($irDeviceDetailsFunctionCodesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-parent-device-id', $actual->getParentDeviceId());
        self::assertSame('test-profile-id', $actual->getProfileId());
        self::assertSame('test-ocf-device-type', $actual->getOcfDeviceType());
        self::assertSame('test-ir-code', $actual->getIrCode());
        self::assertSame($irDeviceDetailsFunctionCodesModel, $actual->getFunctionCodes());
        self::assertCount(1, $actual->getChildDevices() ?? []);
        self::assertSame(['test-metadata-key' => 'test-value'], $actual->getMetadata());
    }

    public function testTransformChildDevices(): void
    {
        $irDeviceDetailsFunctionCodesModel = self::createStub(IrDeviceDetailsFunctionCodesInterface::class);
        $irDeviceDetailsFunctionCodesTransformer = self::createStub(IrDeviceDetailsFunctionCodesTransformerInterface::class);
        $irDeviceDetailsFunctionCodesTransformer->method('transform')->willReturn($irDeviceDetailsFunctionCodesModel);
        $transformer = new IrDeviceDetailsTransformer($irDeviceDetailsFunctionCodesTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getChildDevices());
        self::assertNull($transformer->transform($base + [IrDeviceDetailsTransformerInterface::KEY_CHILD_DEVICES => 'test-not-array'])->getChildDevices());
        self::assertCount(1, $transformer->transform($base + [IrDeviceDetailsTransformerInterface::KEY_CHILD_DEVICES => [[], 'test-skipped']])->getChildDevices() ?? []);
    }

    public function testTransformFunctionCodes(): void
    {
        $irDeviceDetailsFunctionCodesModel = self::createStub(IrDeviceDetailsFunctionCodesInterface::class);
        $irDeviceDetailsFunctionCodesTransformer = self::createStub(IrDeviceDetailsFunctionCodesTransformerInterface::class);
        $irDeviceDetailsFunctionCodesTransformer->method('transform')->willReturn($irDeviceDetailsFunctionCodesModel);
        $transformer = new IrDeviceDetailsTransformer($irDeviceDetailsFunctionCodesTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getFunctionCodes());
        self::assertNull($transformer->transform($base + [IrDeviceDetailsTransformerInterface::KEY_FUNCTION_CODES => 'test-not-array'])->getFunctionCodes());
        self::assertSame($irDeviceDetailsFunctionCodesModel, $transformer->transform($base + [IrDeviceDetailsTransformerInterface::KEY_FUNCTION_CODES => ['test-nested']])->getFunctionCodes());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new IrDeviceDetailsTransformer(self::createStub(IrDeviceDetailsFunctionCodesTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'parentDeviceIdAbsent' => [[], 'getParentDeviceId', null];
        yield 'parentDeviceIdWrongType' => [[IrDeviceDetailsTransformerInterface::KEY_PARENT_DEVICE_ID => 42], 'getParentDeviceId', null];
        yield 'parentDeviceIdValid' => [[IrDeviceDetailsTransformerInterface::KEY_PARENT_DEVICE_ID => 'test-parent-device-id'], 'getParentDeviceId', 'test-parent-device-id'];
        yield 'profileIdAbsent' => [[], 'getProfileId', null];
        yield 'profileIdWrongType' => [[IrDeviceDetailsTransformerInterface::KEY_PROFILE_ID => 42], 'getProfileId', null];
        yield 'profileIdValid' => [[IrDeviceDetailsTransformerInterface::KEY_PROFILE_ID => 'test-profile-id'], 'getProfileId', 'test-profile-id'];
        yield 'ocfDeviceTypeAbsent' => [[], 'getOcfDeviceType', null];
        yield 'ocfDeviceTypeWrongType' => [[IrDeviceDetailsTransformerInterface::KEY_OCF_DEVICE_TYPE => 42], 'getOcfDeviceType', null];
        yield 'ocfDeviceTypeValid' => [[IrDeviceDetailsTransformerInterface::KEY_OCF_DEVICE_TYPE => 'test-ocf-device-type'], 'getOcfDeviceType', 'test-ocf-device-type'];
        yield 'irCodeAbsent' => [[], 'getIrCode', null];
        yield 'irCodeWrongType' => [[IrDeviceDetailsTransformerInterface::KEY_IR_CODE => 42], 'getIrCode', null];
        yield 'irCodeValid' => [[IrDeviceDetailsTransformerInterface::KEY_IR_CODE => 'test-ir-code'], 'getIrCode', 'test-ir-code'];
        yield 'metadataAbsent' => [[], 'getMetadata', null];
        yield 'metadataWrongType' => [[IrDeviceDetailsTransformerInterface::KEY_METADATA => 'not-array'], 'getMetadata', null];
        yield 'metadataValid' => [[IrDeviceDetailsTransformerInterface::KEY_METADATA => ['test-metadata-key' => 'test-value']], 'getMetadata', ['test-metadata-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $irDeviceDetailsFunctionCodesModel = self::createStub(IrDeviceDetailsFunctionCodesInterface::class);
        $irDeviceDetailsFunctionCodesTransformer = self::createStub(IrDeviceDetailsFunctionCodesTransformerInterface::class);
        $irDeviceDetailsFunctionCodesTransformer->method('transform')->willReturn($irDeviceDetailsFunctionCodesModel);
        $transformer = new IrDeviceDetailsTransformer($irDeviceDetailsFunctionCodesTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getParentDeviceId());
        self::assertNull($actual->getProfileId());
        self::assertNull($actual->getOcfDeviceType());
        self::assertNull($actual->getIrCode());
        self::assertNull($actual->getFunctionCodes());
        self::assertNull($actual->getChildDevices());
        self::assertNull($actual->getMetadata());
    }
}
