<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BleD2DDeviceDetails;
use ChristianBrown\SmartThings\Transformer\BleD2DDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\BleD2DDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BleD2DDeviceDetails::class)]
#[CoversClass(BleD2DDeviceDetailsTransformer::class)]
final class BleD2DDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            BleD2DDeviceDetailsTransformerInterface::KEY_ENCRYPTION_KEY => 'test-encryption-key',
            BleD2DDeviceDetailsTransformerInterface::KEY_CIPHER => 'test-cipher',
            BleD2DDeviceDetailsTransformerInterface::KEY_GATT_CIPHER => 'test-gatt-cipher',
            BleD2DDeviceDetailsTransformerInterface::KEY_ADVERTISING_ID => 'test-advertising-id',
            BleD2DDeviceDetailsTransformerInterface::KEY_IDENTIFIER => 'test-identifier',
            BleD2DDeviceDetailsTransformerInterface::KEY_CONFIGURATION_VERSION => 'test-configuration-version',
            BleD2DDeviceDetailsTransformerInterface::KEY_CONFIGURATION_URL => 'test-configuration-url',
            BleD2DDeviceDetailsTransformerInterface::KEY_BLE_DEVICE_TYPE => 'test-ble-device-type',
            BleD2DDeviceDetailsTransformerInterface::KEY_METADATA => ['test-metadata-key' => 'test-value'],
        ];

        $transformer = new BleD2DDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-encryption-key', $actual->getEncryptionKey());
        self::assertSame('test-cipher', $actual->getCipher());
        self::assertSame('test-gatt-cipher', $actual->getGattCipher());
        self::assertSame('test-advertising-id', $actual->getAdvertisingId());
        self::assertSame('test-identifier', $actual->getIdentifier());
        self::assertSame('test-configuration-version', $actual->getConfigurationVersion());
        self::assertSame('test-configuration-url', $actual->getConfigurationUrl());
        self::assertSame('test-ble-device-type', $actual->getBleDeviceType());
        self::assertSame(['test-metadata-key' => 'test-value'], $actual->getMetadata());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BleD2DDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'encryptionKeyAbsent' => [[], 'getEncryptionKey', null];
        yield 'encryptionKeyWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_ENCRYPTION_KEY => 42], 'getEncryptionKey', null];
        yield 'encryptionKeyValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_ENCRYPTION_KEY => 'test-encryption-key'], 'getEncryptionKey', 'test-encryption-key'];
        yield 'cipherAbsent' => [[], 'getCipher', null];
        yield 'cipherWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_CIPHER => 42], 'getCipher', null];
        yield 'cipherValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_CIPHER => 'test-cipher'], 'getCipher', 'test-cipher'];
        yield 'gattCipherAbsent' => [[], 'getGattCipher', null];
        yield 'gattCipherWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_GATT_CIPHER => 42], 'getGattCipher', null];
        yield 'gattCipherValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_GATT_CIPHER => 'test-gatt-cipher'], 'getGattCipher', 'test-gatt-cipher'];
        yield 'advertisingIdAbsent' => [[], 'getAdvertisingId', null];
        yield 'advertisingIdWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_ADVERTISING_ID => 42], 'getAdvertisingId', null];
        yield 'advertisingIdValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_ADVERTISING_ID => 'test-advertising-id'], 'getAdvertisingId', 'test-advertising-id'];
        yield 'identifierAbsent' => [[], 'getIdentifier', null];
        yield 'identifierWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_IDENTIFIER => 42], 'getIdentifier', null];
        yield 'identifierValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_IDENTIFIER => 'test-identifier'], 'getIdentifier', 'test-identifier'];
        yield 'configurationVersionAbsent' => [[], 'getConfigurationVersion', null];
        yield 'configurationVersionWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_CONFIGURATION_VERSION => 42], 'getConfigurationVersion', null];
        yield 'configurationVersionValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_CONFIGURATION_VERSION => 'test-configuration-version'], 'getConfigurationVersion', 'test-configuration-version'];
        yield 'configurationUrlAbsent' => [[], 'getConfigurationUrl', null];
        yield 'configurationUrlWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_CONFIGURATION_URL => 42], 'getConfigurationUrl', null];
        yield 'configurationUrlValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_CONFIGURATION_URL => 'test-configuration-url'], 'getConfigurationUrl', 'test-configuration-url'];
        yield 'bleDeviceTypeAbsent' => [[], 'getBleDeviceType', null];
        yield 'bleDeviceTypeWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_BLE_DEVICE_TYPE => 42], 'getBleDeviceType', null];
        yield 'bleDeviceTypeValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_BLE_DEVICE_TYPE => 'test-ble-device-type'], 'getBleDeviceType', 'test-ble-device-type'];
        yield 'metadataAbsent' => [[], 'getMetadata', null];
        yield 'metadataWrongType' => [[BleD2DDeviceDetailsTransformerInterface::KEY_METADATA => 'not-array'], 'getMetadata', null];
        yield 'metadataValid' => [[BleD2DDeviceDetailsTransformerInterface::KEY_METADATA => ['test-metadata-key' => 'test-value']], 'getMetadata', ['test-metadata-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new BleD2DDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getEncryptionKey());
        self::assertNull($actual->getCipher());
        self::assertNull($actual->getGattCipher());
        self::assertNull($actual->getAdvertisingId());
        self::assertNull($actual->getIdentifier());
        self::assertNull($actual->getConfigurationVersion());
        self::assertNull($actual->getConfigurationUrl());
        self::assertNull($actual->getBleDeviceType());
        self::assertNull($actual->getMetadata());
    }
}
