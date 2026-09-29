<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CommandClassesInterface;
use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\ZWaveGenericFingerprint;
use ChristianBrown\SmartThings\Transformer\CommandClassesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZWaveGenericFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZWaveGenericFingerprintTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ZWaveGenericFingerprint::class)]
#[CoversClass(ZWaveGenericFingerprintTransformer::class)]
final class ZWaveGenericFingerprintTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $commandClassesModel = self::createStub(CommandClassesInterface::class);
        $commandClassesTransformer = self::createStub(CommandClassesTransformerInterface::class);
        $commandClassesTransformer->method('transform')->willReturn($commandClassesModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $data = [
            ZWaveGenericFingerprintTransformerInterface::KEY_GENERIC_TYPE => 7,
            ZWaveGenericFingerprintTransformerInterface::KEY_SPECIFIC_TYPE => [1, 2],
            ZWaveGenericFingerprintTransformerInterface::KEY_COMMAND_CLASSES => ['test-nested'],
            ZWaveGenericFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested'],
        ];

        $transformer = new ZWaveGenericFingerprintTransformer($commandClassesTransformer, $deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getGenericType());
        self::assertSame([1, 2], $actual->getSpecificType());
        self::assertSame($commandClassesModel, $actual->getCommandClasses());
        self::assertSame($deviceIntegrationProfileKeyModel, $actual->getDeviceIntegrationProfileKey());
    }

    public function testTransformCommandClasses(): void
    {
        $commandClassesModel = self::createStub(CommandClassesInterface::class);
        $commandClassesTransformer = self::createStub(CommandClassesTransformerInterface::class);
        $commandClassesTransformer->method('transform')->willReturn($commandClassesModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZWaveGenericFingerprintTransformer($commandClassesTransformer, $deviceIntegrationProfileKeyTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getCommandClasses());
        self::assertNull($transformer->transform($base + [ZWaveGenericFingerprintTransformerInterface::KEY_COMMAND_CLASSES => 'test-not-array'])->getCommandClasses());
        self::assertSame($commandClassesModel, $transformer->transform($base + [ZWaveGenericFingerprintTransformerInterface::KEY_COMMAND_CLASSES => ['test-nested']])->getCommandClasses());
    }

    public function testTransformDeviceIntegrationProfileKey(): void
    {
        $commandClassesModel = self::createStub(CommandClassesInterface::class);
        $commandClassesTransformer = self::createStub(CommandClassesTransformerInterface::class);
        $commandClassesTransformer->method('transform')->willReturn($commandClassesModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZWaveGenericFingerprintTransformer($commandClassesTransformer, $deviceIntegrationProfileKeyTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDeviceIntegrationProfileKey());
        self::assertNull($transformer->transform($base + [ZWaveGenericFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => 'test-not-array'])->getDeviceIntegrationProfileKey());
        self::assertSame($deviceIntegrationProfileKeyModel, $transformer->transform($base + [ZWaveGenericFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested']])->getDeviceIntegrationProfileKey());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ZWaveGenericFingerprintTransformer(self::createStub(CommandClassesTransformerInterface::class), self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'genericTypeAbsent' => [[], 'getGenericType', null];
        yield 'genericTypeWrongType' => [[ZWaveGenericFingerprintTransformerInterface::KEY_GENERIC_TYPE => 'not-int'], 'getGenericType', null];
        yield 'genericTypeValid' => [[ZWaveGenericFingerprintTransformerInterface::KEY_GENERIC_TYPE => 7], 'getGenericType', 7];
        yield 'specificTypeAbsent' => [[], 'getSpecificType', null];
        yield 'specificTypeWrongType' => [[ZWaveGenericFingerprintTransformerInterface::KEY_SPECIFIC_TYPE => 'not-array'], 'getSpecificType', null];
        yield 'specificTypeValid' => [[ZWaveGenericFingerprintTransformerInterface::KEY_SPECIFIC_TYPE => [1, 2]], 'getSpecificType', [1, 2]];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $commandClassesModel = self::createStub(CommandClassesInterface::class);
        $commandClassesTransformer = self::createStub(CommandClassesTransformerInterface::class);
        $commandClassesTransformer->method('transform')->willReturn($commandClassesModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZWaveGenericFingerprintTransformer($commandClassesTransformer, $deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getGenericType());
        self::assertNull($actual->getSpecificType());
        self::assertNull($actual->getCommandClasses());
        self::assertNull($actual->getDeviceIntegrationProfileKey());
    }
}
