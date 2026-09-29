<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\OcfDeviceDetails;
use ChristianBrown\SmartThings\Transformer\OcfDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\OcfDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(OcfDeviceDetails::class)]
#[CoversClass(OcfDeviceDetailsTransformer::class)]
final class OcfDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            OcfDeviceDetailsTransformerInterface::KEY_OCF_DEVICE_TYPE => 'test-ocf-device-type',
            OcfDeviceDetailsTransformerInterface::KEY_NAME => 'test-name',
            OcfDeviceDetailsTransformerInterface::KEY_SPEC_VERSION => 'test-spec-version',
            OcfDeviceDetailsTransformerInterface::KEY_VERTICAL_DOMAIN_SPEC_VERSION => 'test-vertical-domain-spec-version',
            OcfDeviceDetailsTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name',
            OcfDeviceDetailsTransformerInterface::KEY_MODEL_NUMBER => 'test-model-number',
            OcfDeviceDetailsTransformerInterface::KEY_PLATFORM_VERSION => 'test-platform-version',
            OcfDeviceDetailsTransformerInterface::KEY_PLATFORM_OS => 'test-platform-os',
            OcfDeviceDetailsTransformerInterface::KEY_HW_VERSION => 'test-hw-version',
            OcfDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version',
            OcfDeviceDetailsTransformerInterface::KEY_VENDOR_ID => 'test-vendor-id',
            OcfDeviceDetailsTransformerInterface::KEY_VENDOR_RESOURCE_CLIENT_SERVER_VERSION => 'test-vendor-resource-client-server-version',
            OcfDeviceDetailsTransformerInterface::KEY_LOCALE => 'test-locale',
            OcfDeviceDetailsTransformerInterface::KEY_LAST_SIGNUP_TIME => 'test-last-signup-time',
            OcfDeviceDetailsTransformerInterface::KEY_TRANSFER_CANDIDATE => true,
            OcfDeviceDetailsTransformerInterface::KEY_ADDITIONAL_AUTH_CODE_REQUIRED => true,
            OcfDeviceDetailsTransformerInterface::KEY_MODEL_CODE => 'test-model-code',
        ];

        $transformer = new OcfDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-ocf-device-type', $actual->getOcfDeviceType());
        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-spec-version', $actual->getSpecVersion());
        self::assertSame('test-vertical-domain-spec-version', $actual->getVerticalDomainSpecVersion());
        self::assertSame('test-manufacturer-name', $actual->getManufacturerName());
        self::assertSame('test-model-number', $actual->getModelNumber());
        self::assertSame('test-platform-version', $actual->getPlatformVersion());
        self::assertSame('test-platform-os', $actual->getPlatformOS());
        self::assertSame('test-hw-version', $actual->getHwVersion());
        self::assertSame('test-firmware-version', $actual->getFirmwareVersion());
        self::assertSame('test-vendor-id', $actual->getVendorId());
        self::assertSame('test-vendor-resource-client-server-version', $actual->getVendorResourceClientServerVersion());
        self::assertSame('test-locale', $actual->getLocale());
        self::assertSame('test-last-signup-time', $actual->getLastSignupTime());
        self::assertTrue($actual->getTransferCandidate());
        self::assertTrue($actual->getAdditionalAuthCodeRequired());
        self::assertSame('test-model-code', $actual->getModelCode());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new OcfDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'ocfDeviceTypeAbsent' => [[], 'getOcfDeviceType', null];
        yield 'ocfDeviceTypeWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_OCF_DEVICE_TYPE => 42], 'getOcfDeviceType', null];
        yield 'ocfDeviceTypeValid' => [[OcfDeviceDetailsTransformerInterface::KEY_OCF_DEVICE_TYPE => 'test-ocf-device-type'], 'getOcfDeviceType', 'test-ocf-device-type'];
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[OcfDeviceDetailsTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'specVersionAbsent' => [[], 'getSpecVersion', null];
        yield 'specVersionWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_SPEC_VERSION => 42], 'getSpecVersion', null];
        yield 'specVersionValid' => [[OcfDeviceDetailsTransformerInterface::KEY_SPEC_VERSION => 'test-spec-version'], 'getSpecVersion', 'test-spec-version'];
        yield 'verticalDomainSpecVersionAbsent' => [[], 'getVerticalDomainSpecVersion', null];
        yield 'verticalDomainSpecVersionWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_VERTICAL_DOMAIN_SPEC_VERSION => 42], 'getVerticalDomainSpecVersion', null];
        yield 'verticalDomainSpecVersionValid' => [[OcfDeviceDetailsTransformerInterface::KEY_VERTICAL_DOMAIN_SPEC_VERSION => 'test-vertical-domain-spec-version'], 'getVerticalDomainSpecVersion', 'test-vertical-domain-spec-version'];
        yield 'manufacturerNameAbsent' => [[], 'getManufacturerName', null];
        yield 'manufacturerNameWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_MANUFACTURER_NAME => 42], 'getManufacturerName', null];
        yield 'manufacturerNameValid' => [[OcfDeviceDetailsTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name'], 'getManufacturerName', 'test-manufacturer-name'];
        yield 'modelNumberAbsent' => [[], 'getModelNumber', null];
        yield 'modelNumberWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_MODEL_NUMBER => 42], 'getModelNumber', null];
        yield 'modelNumberValid' => [[OcfDeviceDetailsTransformerInterface::KEY_MODEL_NUMBER => 'test-model-number'], 'getModelNumber', 'test-model-number'];
        yield 'platformVersionAbsent' => [[], 'getPlatformVersion', null];
        yield 'platformVersionWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_PLATFORM_VERSION => 42], 'getPlatformVersion', null];
        yield 'platformVersionValid' => [[OcfDeviceDetailsTransformerInterface::KEY_PLATFORM_VERSION => 'test-platform-version'], 'getPlatformVersion', 'test-platform-version'];
        yield 'platformOSAbsent' => [[], 'getPlatformOS', null];
        yield 'platformOSWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_PLATFORM_OS => 42], 'getPlatformOS', null];
        yield 'platformOSValid' => [[OcfDeviceDetailsTransformerInterface::KEY_PLATFORM_OS => 'test-platform-os'], 'getPlatformOS', 'test-platform-os'];
        yield 'hwVersionAbsent' => [[], 'getHwVersion', null];
        yield 'hwVersionWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_HW_VERSION => 42], 'getHwVersion', null];
        yield 'hwVersionValid' => [[OcfDeviceDetailsTransformerInterface::KEY_HW_VERSION => 'test-hw-version'], 'getHwVersion', 'test-hw-version'];
        yield 'firmwareVersionAbsent' => [[], 'getFirmwareVersion', null];
        yield 'firmwareVersionWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 42], 'getFirmwareVersion', null];
        yield 'firmwareVersionValid' => [[OcfDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version'], 'getFirmwareVersion', 'test-firmware-version'];
        yield 'vendorIdAbsent' => [[], 'getVendorId', null];
        yield 'vendorIdWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_VENDOR_ID => 42], 'getVendorId', null];
        yield 'vendorIdValid' => [[OcfDeviceDetailsTransformerInterface::KEY_VENDOR_ID => 'test-vendor-id'], 'getVendorId', 'test-vendor-id'];
        yield 'vendorResourceClientServerVersionAbsent' => [[], 'getVendorResourceClientServerVersion', null];
        yield 'vendorResourceClientServerVersionWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_VENDOR_RESOURCE_CLIENT_SERVER_VERSION => 42], 'getVendorResourceClientServerVersion', null];
        yield 'vendorResourceClientServerVersionValid' => [[OcfDeviceDetailsTransformerInterface::KEY_VENDOR_RESOURCE_CLIENT_SERVER_VERSION => 'test-vendor-resource-client-server-version'], 'getVendorResourceClientServerVersion', 'test-vendor-resource-client-server-version'];
        yield 'localeAbsent' => [[], 'getLocale', null];
        yield 'localeWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_LOCALE => 42], 'getLocale', null];
        yield 'localeValid' => [[OcfDeviceDetailsTransformerInterface::KEY_LOCALE => 'test-locale'], 'getLocale', 'test-locale'];
        yield 'lastSignupTimeAbsent' => [[], 'getLastSignupTime', null];
        yield 'lastSignupTimeWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_LAST_SIGNUP_TIME => 42], 'getLastSignupTime', null];
        yield 'lastSignupTimeValid' => [[OcfDeviceDetailsTransformerInterface::KEY_LAST_SIGNUP_TIME => 'test-last-signup-time'], 'getLastSignupTime', 'test-last-signup-time'];
        yield 'transferCandidateAbsent' => [[], 'getTransferCandidate', null];
        yield 'transferCandidateWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_TRANSFER_CANDIDATE => 'not-bool'], 'getTransferCandidate', null];
        yield 'transferCandidateValid' => [[OcfDeviceDetailsTransformerInterface::KEY_TRANSFER_CANDIDATE => true], 'getTransferCandidate', true];
        yield 'additionalAuthCodeRequiredAbsent' => [[], 'getAdditionalAuthCodeRequired', null];
        yield 'additionalAuthCodeRequiredWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_ADDITIONAL_AUTH_CODE_REQUIRED => 'not-bool'], 'getAdditionalAuthCodeRequired', null];
        yield 'additionalAuthCodeRequiredValid' => [[OcfDeviceDetailsTransformerInterface::KEY_ADDITIONAL_AUTH_CODE_REQUIRED => true], 'getAdditionalAuthCodeRequired', true];
        yield 'modelCodeAbsent' => [[], 'getModelCode', null];
        yield 'modelCodeWrongType' => [[OcfDeviceDetailsTransformerInterface::KEY_MODEL_CODE => 42], 'getModelCode', null];
        yield 'modelCodeValid' => [[OcfDeviceDetailsTransformerInterface::KEY_MODEL_CODE => 'test-model-code'], 'getModelCode', 'test-model-code'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new OcfDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getOcfDeviceType());
        self::assertNull($actual->getName());
        self::assertNull($actual->getSpecVersion());
        self::assertNull($actual->getVerticalDomainSpecVersion());
        self::assertNull($actual->getManufacturerName());
        self::assertNull($actual->getModelNumber());
        self::assertNull($actual->getPlatformVersion());
        self::assertNull($actual->getPlatformOS());
        self::assertNull($actual->getHwVersion());
        self::assertNull($actual->getFirmwareVersion());
        self::assertNull($actual->getVendorId());
        self::assertNull($actual->getVendorResourceClientServerVersion());
        self::assertNull($actual->getLocale());
        self::assertNull($actual->getLastSignupTime());
        self::assertNull($actual->getTransferCandidate());
        self::assertNull($actual->getAdditionalAuthCodeRequired());
        self::assertNull($actual->getModelCode());
    }
}
