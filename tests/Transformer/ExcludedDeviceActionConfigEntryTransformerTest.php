<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntry;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceActionConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceActionConfigEntryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PatchItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExcludedDeviceActionConfigEntry::class)]
#[CoversClass(ExcludedDeviceActionConfigEntryTransformer::class)]
final class ExcludedDeviceActionConfigEntryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdTransformer = self::createStub(ExcludedActionItemIdTransformerInterface::class);
        $excludedActionItemIdTransformer->method('transform')->willReturn($excludedActionItemIdModel);
        $data = [
            ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component',
            ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability',
            ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VERSION => 7,
            ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VALUES => [['test-nested']],
            ExcludedDeviceActionConfigEntryTransformerInterface::KEY_PATCH => [['test-nested']],
            ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
            ExcludedDeviceActionConfigEntryTransformerInterface::KEY_EXCLUSION => [['test-nested']],
        ];

        $transformer = new ExcludedDeviceActionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedActionItemIdTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame([$capabilityValueModel], $actual->getValues());
        self::assertSame([$patchItemModel], $actual->getPatch());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
        self::assertSame([$excludedActionItemIdModel], $actual->getExclusion());
    }

    public function testTransformExclusion(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdTransformer = self::createStub(ExcludedActionItemIdTransformerInterface::class);
        $excludedActionItemIdTransformer->method('transform')->willReturn($excludedActionItemIdModel);
        $transformer = new ExcludedDeviceActionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedActionItemIdTransformer);
        $base = [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getExclusion());
        self::assertNull($transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_EXCLUSION => 'test-not-array'])->getExclusion());
        self::assertSame([$excludedActionItemIdModel], $transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_EXCLUSION => [['test-nested'], 'test-skipped']])->getExclusion());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedDeviceActionConfigEntryTransformer(self::createStub(CapabilityValueTransformerInterface::class), self::createStub(PatchItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class), self::createStub(ExcludedActionItemIdTransformerInterface::class));

        $actual = $transformer->transform([ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformPatch(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdTransformer = self::createStub(ExcludedActionItemIdTransformerInterface::class);
        $excludedActionItemIdTransformer->method('transform')->willReturn($excludedActionItemIdModel);
        $transformer = new ExcludedDeviceActionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedActionItemIdTransformer);
        $base = [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getPatch());
        self::assertNull($transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_PATCH => 'test-not-array'])->getPatch());
        self::assertSame([$patchItemModel], $transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_PATCH => [['test-nested'], 'test-skipped']])->getPatch());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdTransformer = self::createStub(ExcludedActionItemIdTransformerInterface::class);
        $excludedActionItemIdTransformer->method('transform')->willReturn($excludedActionItemIdModel);
        $transformer = new ExcludedDeviceActionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedActionItemIdTransformer);

        $actual = $transformer->transform([ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getValues());
        self::assertNull($actual->getPatch());
        self::assertNull($actual->getVisibleCondition());
        self::assertNull($actual->getExclusion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ExcludedDeviceActionConfigEntryTransformer(self::createStub(CapabilityValueTransformerInterface::class), self::createStub(PatchItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class), self::createStub(ExcludedActionItemIdTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'componentAbsent' => [[ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(ExcludedDeviceActionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 42], sprintf(ExcludedDeviceActionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT)];
        yield 'capabilityAbsent' => [[ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(ExcludedDeviceActionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 42], sprintf(ExcludedDeviceActionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY)];
    }

    public function testTransformValues(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdTransformer = self::createStub(ExcludedActionItemIdTransformerInterface::class);
        $excludedActionItemIdTransformer->method('transform')->willReturn($excludedActionItemIdModel);
        $transformer = new ExcludedDeviceActionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedActionItemIdTransformer);
        $base = [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getValues());
        self::assertNull($transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VALUES => 'test-not-array'])->getValues());
        self::assertSame([$capabilityValueModel], $transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VALUES => [['test-nested'], 'test-skipped']])->getValues());
    }

    public function testTransformVisibleCondition(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueTransformer = self::createStub(CapabilityValueTransformerInterface::class);
        $capabilityValueTransformer->method('transform')->willReturn($capabilityValueModel);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemTransformer = self::createStub(PatchItemTransformerInterface::class);
        $patchItemTransformer->method('transform')->willReturn($patchItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdTransformer = self::createStub(ExcludedActionItemIdTransformerInterface::class);
        $excludedActionItemIdTransformer->method('transform')->willReturn($excludedActionItemIdModel);
        $transformer = new ExcludedDeviceActionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedActionItemIdTransformer);
        $base = [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceActionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [ExcludedDeviceActionConfigEntryTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
