<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AttributeStateInterface;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationInterface;
use ChristianBrown\SmartThings\Model\DeviceCapabilityReference;
use ChristianBrown\SmartThings\Model\RestrictionInterface;
use ChristianBrown\SmartThings\Transformer\AttributeStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCapabilityReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCapabilityReferenceTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RestrictionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceCapabilityReference::class)]
#[CoversClass(DeviceCapabilityReferenceTransformer::class)]
final class DeviceCapabilityReferenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityConfigurationModel = self::createStub(CapabilityConfigurationInterface::class);
        $capabilityConfigurationTransformer = self::createStub(CapabilityConfigurationTransformerInterface::class);
        $capabilityConfigurationTransformer->method('transform')->willReturn($capabilityConfigurationModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $attributeStateModel = self::createStub(AttributeStateInterface::class);
        $attributeStateTransformer = self::createStub(AttributeStateTransformerInterface::class);
        $attributeStateTransformer->method('transform')->willReturn($attributeStateModel);
        $data = [
            DeviceCapabilityReferenceTransformerInterface::KEY_ID => 'test-id',
            DeviceCapabilityReferenceTransformerInterface::KEY_VERSION => 7,
            DeviceCapabilityReferenceTransformerInterface::KEY_OPTIONAL => true,
            DeviceCapabilityReferenceTransformerInterface::KEY_CONFIG => ['test-nested'],
            DeviceCapabilityReferenceTransformerInterface::KEY_RESTRICTIONS => ['test-nested'],
            DeviceCapabilityReferenceTransformerInterface::KEY_EPHEMERAL => true,
            DeviceCapabilityReferenceTransformerInterface::KEY_STATUS => ['test-key' => ['test-nested']],
        ];

        $transformer = new DeviceCapabilityReferenceTransformer($capabilityConfigurationTransformer, $restrictionTransformer, $attributeStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-id', $actual->getId());
        self::assertSame(7, $actual->getVersion());
        self::assertTrue($actual->getOptional());
        self::assertSame($capabilityConfigurationModel, $actual->getConfig());
        self::assertSame($restrictionModel, $actual->getRestrictions());
        self::assertTrue($actual->getEphemeral());
        self::assertSame(['test-key' => $attributeStateModel], $actual->getStatus());
    }

    public function testTransformConfig(): void
    {
        $capabilityConfigurationModel = self::createStub(CapabilityConfigurationInterface::class);
        $capabilityConfigurationTransformer = self::createStub(CapabilityConfigurationTransformerInterface::class);
        $capabilityConfigurationTransformer->method('transform')->willReturn($capabilityConfigurationModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $attributeStateModel = self::createStub(AttributeStateInterface::class);
        $attributeStateTransformer = self::createStub(AttributeStateTransformerInterface::class);
        $attributeStateTransformer->method('transform')->willReturn($attributeStateModel);
        $transformer = new DeviceCapabilityReferenceTransformer($capabilityConfigurationTransformer, $restrictionTransformer, $attributeStateTransformer);
        $base = [DeviceCapabilityReferenceTransformerInterface::KEY_ID => 'test-id'];

        self::assertNull($transformer->transform($base)->getConfig());
        self::assertNull($transformer->transform($base + [DeviceCapabilityReferenceTransformerInterface::KEY_CONFIG => 'test-not-array'])->getConfig());
        self::assertSame($capabilityConfigurationModel, $transformer->transform($base + [DeviceCapabilityReferenceTransformerInterface::KEY_CONFIG => ['test-nested']])->getConfig());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceCapabilityReferenceTransformer(self::createStub(CapabilityConfigurationTransformerInterface::class), self::createStub(RestrictionTransformerInterface::class), self::createStub(AttributeStateTransformerInterface::class));

        $actual = $transformer->transform([DeviceCapabilityReferenceTransformerInterface::KEY_ID => 'test-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[DeviceCapabilityReferenceTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[DeviceCapabilityReferenceTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'optionalAbsent' => [[], 'getOptional', null];
        yield 'optionalWrongType' => [[DeviceCapabilityReferenceTransformerInterface::KEY_OPTIONAL => 'not-bool'], 'getOptional', null];
        yield 'optionalValid' => [[DeviceCapabilityReferenceTransformerInterface::KEY_OPTIONAL => true], 'getOptional', true];
        yield 'ephemeralAbsent' => [[], 'getEphemeral', null];
        yield 'ephemeralWrongType' => [[DeviceCapabilityReferenceTransformerInterface::KEY_EPHEMERAL => 'not-bool'], 'getEphemeral', null];
        yield 'ephemeralValid' => [[DeviceCapabilityReferenceTransformerInterface::KEY_EPHEMERAL => true], 'getEphemeral', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityConfigurationModel = self::createStub(CapabilityConfigurationInterface::class);
        $capabilityConfigurationTransformer = self::createStub(CapabilityConfigurationTransformerInterface::class);
        $capabilityConfigurationTransformer->method('transform')->willReturn($capabilityConfigurationModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $attributeStateModel = self::createStub(AttributeStateInterface::class);
        $attributeStateTransformer = self::createStub(AttributeStateTransformerInterface::class);
        $attributeStateTransformer->method('transform')->willReturn($attributeStateModel);
        $transformer = new DeviceCapabilityReferenceTransformer($capabilityConfigurationTransformer, $restrictionTransformer, $attributeStateTransformer);

        $actual = $transformer->transform([DeviceCapabilityReferenceTransformerInterface::KEY_ID => 'test-id']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getOptional());
        self::assertNull($actual->getConfig());
        self::assertNull($actual->getRestrictions());
        self::assertNull($actual->getEphemeral());
        self::assertNull($actual->getStatus());
    }

    public function testTransformRestrictions(): void
    {
        $capabilityConfigurationModel = self::createStub(CapabilityConfigurationInterface::class);
        $capabilityConfigurationTransformer = self::createStub(CapabilityConfigurationTransformerInterface::class);
        $capabilityConfigurationTransformer->method('transform')->willReturn($capabilityConfigurationModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $attributeStateModel = self::createStub(AttributeStateInterface::class);
        $attributeStateTransformer = self::createStub(AttributeStateTransformerInterface::class);
        $attributeStateTransformer->method('transform')->willReturn($attributeStateModel);
        $transformer = new DeviceCapabilityReferenceTransformer($capabilityConfigurationTransformer, $restrictionTransformer, $attributeStateTransformer);
        $base = [DeviceCapabilityReferenceTransformerInterface::KEY_ID => 'test-id'];

        self::assertNull($transformer->transform($base)->getRestrictions());
        self::assertNull($transformer->transform($base + [DeviceCapabilityReferenceTransformerInterface::KEY_RESTRICTIONS => 'test-not-array'])->getRestrictions());
        self::assertSame($restrictionModel, $transformer->transform($base + [DeviceCapabilityReferenceTransformerInterface::KEY_RESTRICTIONS => ['test-nested']])->getRestrictions());
    }

    public function testTransformStatus(): void
    {
        $capabilityConfigurationModel = self::createStub(CapabilityConfigurationInterface::class);
        $capabilityConfigurationTransformer = self::createStub(CapabilityConfigurationTransformerInterface::class);
        $capabilityConfigurationTransformer->method('transform')->willReturn($capabilityConfigurationModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $attributeStateModel = self::createStub(AttributeStateInterface::class);
        $attributeStateTransformer = self::createStub(AttributeStateTransformerInterface::class);
        $attributeStateTransformer->method('transform')->willReturn($attributeStateModel);
        $transformer = new DeviceCapabilityReferenceTransformer($capabilityConfigurationTransformer, $restrictionTransformer, $attributeStateTransformer);
        $base = [DeviceCapabilityReferenceTransformerInterface::KEY_ID => 'test-id'];

        self::assertNull($transformer->transform($base)->getStatus());
        self::assertNull($transformer->transform($base + [DeviceCapabilityReferenceTransformerInterface::KEY_STATUS => 'test-not-array'])->getStatus());
        self::assertSame(['test-key' => $attributeStateModel], $transformer->transform($base + [DeviceCapabilityReferenceTransformerInterface::KEY_STATUS => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getStatus());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceCapabilityReferenceTransformer(self::createStub(CapabilityConfigurationTransformerInterface::class), self::createStub(RestrictionTransformerInterface::class), self::createStub(AttributeStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'idAbsent' => [[], sprintf(DeviceCapabilityReferenceTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceCapabilityReferenceTransformerInterface::KEY_ID)];
        yield 'idWrongType' => [[DeviceCapabilityReferenceTransformerInterface::KEY_ID => 42], sprintf(DeviceCapabilityReferenceTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceCapabilityReferenceTransformerInterface::KEY_ID)];
    }
}
