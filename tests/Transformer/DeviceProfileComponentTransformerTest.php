<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCapabilityReferenceInterface;
use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileComponent;
use ChristianBrown\SmartThings\Model\RestrictionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCapabilityReferenceTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileComponentTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RestrictionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceProfileComponent::class)]
#[CoversClass(DeviceProfileComponentTransformer::class)]
final class DeviceProfileComponentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceCapabilityReferenceModel = self::createStub(DeviceCapabilityReferenceInterface::class);
        $deviceCapabilityReferenceTransformer = self::createStub(DeviceCapabilityReferenceTransformerInterface::class);
        $deviceCapabilityReferenceTransformer->method('transform')->willReturn($deviceCapabilityReferenceModel);
        $deviceCategoryModel = self::createStub(DeviceCategoryInterface::class);
        $deviceCategoryTransformer = self::createStub(DeviceCategoryTransformerInterface::class);
        $deviceCategoryTransformer->method('transform')->willReturn($deviceCategoryModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $data = [
            DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id',
            DeviceProfileComponentTransformerInterface::KEY_LABEL => 'test-label',
            DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => [['test-nested']],
            DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => [['test-nested']],
            DeviceProfileComponentTransformerInterface::KEY_RESTRICTIONS => ['test-nested'],
            DeviceProfileComponentTransformerInterface::KEY_OPTIONAL => true,
        ];

        $transformer = new DeviceProfileComponentTransformer($deviceCapabilityReferenceTransformer, $deviceCategoryTransformer, $restrictionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-id', $actual->getId());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$deviceCapabilityReferenceModel], $actual->getCapabilities());
        self::assertSame([$deviceCategoryModel], $actual->getCategories());
        self::assertSame($restrictionModel, $actual->getRestrictions());
        self::assertTrue($actual->getOptional());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceProfileComponentTransformer(self::createStub(DeviceCapabilityReferenceTransformerInterface::class), self::createStub(DeviceCategoryTransformerInterface::class), self::createStub(RestrictionTransformerInterface::class));

        $actual = $transformer->transform([DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id', DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[DeviceProfileComponentTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[DeviceProfileComponentTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'optionalAbsent' => [[], 'getOptional', null];
        yield 'optionalWrongType' => [[DeviceProfileComponentTransformerInterface::KEY_OPTIONAL => 'not-bool'], 'getOptional', null];
        yield 'optionalValid' => [[DeviceProfileComponentTransformerInterface::KEY_OPTIONAL => true], 'getOptional', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceCapabilityReferenceModel = self::createStub(DeviceCapabilityReferenceInterface::class);
        $deviceCapabilityReferenceTransformer = self::createStub(DeviceCapabilityReferenceTransformerInterface::class);
        $deviceCapabilityReferenceTransformer->method('transform')->willReturn($deviceCapabilityReferenceModel);
        $deviceCategoryModel = self::createStub(DeviceCategoryInterface::class);
        $deviceCategoryTransformer = self::createStub(DeviceCategoryTransformerInterface::class);
        $deviceCategoryTransformer->method('transform')->willReturn($deviceCategoryModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $transformer = new DeviceProfileComponentTransformer($deviceCapabilityReferenceTransformer, $deviceCategoryTransformer, $restrictionTransformer);

        $actual = $transformer->transform([DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id', DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => ['test-nested']]);

        self::assertNull($actual->getLabel());
        self::assertNull($actual->getRestrictions());
        self::assertNull($actual->getOptional());
    }

    public function testTransformRestrictions(): void
    {
        $deviceCapabilityReferenceModel = self::createStub(DeviceCapabilityReferenceInterface::class);
        $deviceCapabilityReferenceTransformer = self::createStub(DeviceCapabilityReferenceTransformerInterface::class);
        $deviceCapabilityReferenceTransformer->method('transform')->willReturn($deviceCapabilityReferenceModel);
        $deviceCategoryModel = self::createStub(DeviceCategoryInterface::class);
        $deviceCategoryTransformer = self::createStub(DeviceCategoryTransformerInterface::class);
        $deviceCategoryTransformer->method('transform')->willReturn($deviceCategoryModel);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createStub(RestrictionTransformerInterface::class);
        $restrictionTransformer->method('transform')->willReturn($restrictionModel);
        $transformer = new DeviceProfileComponentTransformer($deviceCapabilityReferenceTransformer, $deviceCategoryTransformer, $restrictionTransformer);
        $base = [DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id', DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => ['test-nested']];

        self::assertNull($transformer->transform($base)->getRestrictions());
        self::assertNull($transformer->transform($base + [DeviceProfileComponentTransformerInterface::KEY_RESTRICTIONS => 'test-not-array'])->getRestrictions());
        self::assertSame($restrictionModel, $transformer->transform($base + [DeviceProfileComponentTransformerInterface::KEY_RESTRICTIONS => ['test-nested']])->getRestrictions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceProfileComponentTransformer(self::createStub(DeviceCapabilityReferenceTransformerInterface::class), self::createStub(DeviceCategoryTransformerInterface::class), self::createStub(RestrictionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'idAbsent' => [[DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => ['test-nested']], sprintf(DeviceProfileComponentTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceProfileComponentTransformerInterface::KEY_ID)];
        yield 'idWrongType' => [[DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_ID => 42], sprintf(DeviceProfileComponentTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceProfileComponentTransformerInterface::KEY_ID)];
        yield 'capabilitiesAbsent' => [[DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id', DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => ['test-nested']], sprintf(DeviceProfileComponentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES)];
        yield 'capabilitiesWrongType' => [[DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id', DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => 'not-array'], sprintf(DeviceProfileComponentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES)];
        yield 'categoriesAbsent' => [[DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id', DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => ['test-nested']], sprintf(DeviceProfileComponentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceProfileComponentTransformerInterface::KEY_CATEGORIES)];
        yield 'categoriesWrongType' => [[DeviceProfileComponentTransformerInterface::KEY_ID => 'test-id', DeviceProfileComponentTransformerInterface::KEY_CAPABILITIES => ['test-nested'], DeviceProfileComponentTransformerInterface::KEY_CATEGORIES => 'not-array'], sprintf(DeviceProfileComponentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceProfileComponentTransformerInterface::KEY_CATEGORIES)];
    }
}
