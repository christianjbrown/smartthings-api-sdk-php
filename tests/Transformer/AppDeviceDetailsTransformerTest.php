<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AppDeviceDetails;
use ChristianBrown\SmartThings\Model\DeviceProfileReferenceInterface;
use ChristianBrown\SmartThings\Transformer\AppDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppDeviceDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppDeviceDetails::class)]
#[CoversClass(AppDeviceDetailsTransformer::class)]
final class AppDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceProfileReferenceModel = self::createStub(DeviceProfileReferenceInterface::class);
        $deviceProfileReferenceTransformer = self::createStub(DeviceProfileReferenceTransformerInterface::class);
        $deviceProfileReferenceTransformer->method('transform')->willReturn($deviceProfileReferenceModel);
        $data = [
            AppDeviceDetailsTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
            AppDeviceDetailsTransformerInterface::KEY_EXTERNAL_ID => 'test-external-id',
            AppDeviceDetailsTransformerInterface::KEY_PROFILE => ['test-nested'],
        ];

        $transformer = new AppDeviceDetailsTransformer($deviceProfileReferenceTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-installed-app-id', $actual->getInstalledAppId());
        self::assertSame('test-external-id', $actual->getExternalId());
        self::assertSame($deviceProfileReferenceModel, $actual->getProfile());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AppDeviceDetailsTransformer(self::createStub(DeviceProfileReferenceTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'installedAppIdAbsent' => [[], 'getInstalledAppId', null];
        yield 'installedAppIdWrongType' => [[AppDeviceDetailsTransformerInterface::KEY_INSTALLED_APP_ID => 42], 'getInstalledAppId', null];
        yield 'installedAppIdValid' => [[AppDeviceDetailsTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id'], 'getInstalledAppId', 'test-installed-app-id'];
        yield 'externalIdAbsent' => [[], 'getExternalId', null];
        yield 'externalIdWrongType' => [[AppDeviceDetailsTransformerInterface::KEY_EXTERNAL_ID => 42], 'getExternalId', null];
        yield 'externalIdValid' => [[AppDeviceDetailsTransformerInterface::KEY_EXTERNAL_ID => 'test-external-id'], 'getExternalId', 'test-external-id'];
    }

    public function testTransformProfile(): void
    {
        $deviceProfileReferenceModel = self::createStub(DeviceProfileReferenceInterface::class);
        $deviceProfileReferenceTransformer = self::createStub(DeviceProfileReferenceTransformerInterface::class);
        $deviceProfileReferenceTransformer->method('transform')->willReturn($deviceProfileReferenceModel);
        $transformer = new AppDeviceDetailsTransformer($deviceProfileReferenceTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getProfile());
        self::assertNull($transformer->transform($base + [AppDeviceDetailsTransformerInterface::KEY_PROFILE => 'test-not-array'])->getProfile());
        self::assertSame($deviceProfileReferenceModel, $transformer->transform($base + [AppDeviceDetailsTransformerInterface::KEY_PROFILE => ['test-nested']])->getProfile());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceProfileReferenceModel = self::createStub(DeviceProfileReferenceInterface::class);
        $deviceProfileReferenceTransformer = self::createStub(DeviceProfileReferenceTransformerInterface::class);
        $deviceProfileReferenceTransformer->method('transform')->willReturn($deviceProfileReferenceModel);
        $transformer = new AppDeviceDetailsTransformer($deviceProfileReferenceTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getInstalledAppId());
        self::assertNull($actual->getExternalId());
        self::assertNull($actual->getProfile());
    }
}
