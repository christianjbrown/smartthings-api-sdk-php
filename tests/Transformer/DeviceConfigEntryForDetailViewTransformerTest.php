<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailView;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForDetailViewInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDetailViewTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PatchItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDetailViewTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDetailView::class)]
#[CoversClass(DeviceConfigEntryForDetailViewTransformer::class)]
final class DeviceConfigEntryForDetailViewTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $data = [
            DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component',
            DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability',
            DeviceConfigEntryForDetailViewTransformerInterface::KEY_VERSION => 7,
            DeviceConfigEntryForDetailViewTransformerInterface::KEY_VALUES => [['test-nested']],
            DeviceConfigEntryForDetailViewTransformerInterface::KEY_PATCH => [['test-nested']],
            DeviceConfigEntryForDetailViewTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new DeviceConfigEntryForDetailViewTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionForDetailViewTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame([$capabilityValueModel], $actual->getValues());
        self::assertSame([$patchItemModel], $actual->getPatch());
        self::assertSame($visibleConditionForDetailViewModel, $actual->getVisibleCondition());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDetailViewTransformer(self::createStub(CapabilityValueTransformerInterface::class), self::createStub(PatchItemTransformerInterface::class), self::createStub(VisibleConditionForDetailViewTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'componentAbsent' => [[DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getComponent', null];
        yield 'componentWrongType' => [[DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability', DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCapability', null];
        yield 'capabilityWrongType' => [[DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDetailViewTransformer(self::createStub(CapabilityValueTransformerInterface::class), self::createStub(PatchItemTransformerInterface::class), self::createStub(VisibleConditionForDetailViewTransformerInterface::class));

        $actual = $transformer->transform([DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[DeviceConfigEntryForDetailViewTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[DeviceConfigEntryForDetailViewTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformPatch(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DeviceConfigEntryForDetailViewTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getPatch());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDetailViewTransformerInterface::KEY_PATCH => 'test-not-array'])->getPatch());
        self::assertSame([$patchItemModel], $transformer->transform($base + [DeviceConfigEntryForDetailViewTransformerInterface::KEY_PATCH => [['test-nested'], 'test-skipped']])->getPatch());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DeviceConfigEntryForDetailViewTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionForDetailViewTransformer);

        $actual = $transformer->transform([DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getValues());
        self::assertNull($actual->getPatch());
        self::assertNull($actual->getVisibleCondition());
    }

    public function testTransformValues(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DeviceConfigEntryForDetailViewTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getValues());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDetailViewTransformerInterface::KEY_VALUES => 'test-not-array'])->getValues());
        self::assertSame([$capabilityValueModel], $transformer->transform($base + [DeviceConfigEntryForDetailViewTransformerInterface::KEY_VALUES => [['test-nested'], 'test-skipped']])->getValues());
    }

    public function testTransformVisibleCondition(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DeviceConfigEntryForDetailViewTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DeviceConfigEntryForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDetailViewTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionForDetailViewModel, $transformer->transform($base + [DeviceConfigEntryForDetailViewTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
