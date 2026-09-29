<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntry;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceConditionConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceConditionConfigEntryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PatchItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExcludedDeviceConditionConfigEntry::class)]
#[CoversClass(ExcludedDeviceConditionConfigEntryTransformer::class)]
final class ExcludedDeviceConditionConfigEntryTransformerTest extends TestCase
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdTransformer = self::createStub(ExcludedConditionItemIdTransformerInterface::class);
        $excludedConditionItemIdTransformer->method('transform')->willReturn($excludedConditionItemIdModel);
        $data = [
            ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component',
            ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability',
            ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VERSION => 7,
            ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VALUES => [['test-nested']],
            ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_PATCH => [['test-nested']],
            ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
            ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_EXCLUSION => [['test-nested']],
        ];

        $transformer = new ExcludedDeviceConditionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedConditionItemIdTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame([$capabilityValueModel], $actual->getValues());
        self::assertSame([$patchItemModel], $actual->getPatch());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
        self::assertSame([$excludedConditionItemIdModel], $actual->getExclusion());
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdTransformer = self::createStub(ExcludedConditionItemIdTransformerInterface::class);
        $excludedConditionItemIdTransformer->method('transform')->willReturn($excludedConditionItemIdModel);
        $transformer = new ExcludedDeviceConditionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedConditionItemIdTransformer);
        $base = [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getExclusion());
        self::assertNull($transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_EXCLUSION => 'test-not-array'])->getExclusion());
        self::assertSame([$excludedConditionItemIdModel], $transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_EXCLUSION => [['test-nested'], 'test-skipped']])->getExclusion());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedDeviceConditionConfigEntryTransformer(self::createStub(CapabilityValueTransformerInterface::class), self::createStub(PatchItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class), self::createStub(ExcludedConditionItemIdTransformerInterface::class));

        $actual = $transformer->transform([ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdTransformer = self::createStub(ExcludedConditionItemIdTransformerInterface::class);
        $excludedConditionItemIdTransformer->method('transform')->willReturn($excludedConditionItemIdModel);
        $transformer = new ExcludedDeviceConditionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedConditionItemIdTransformer);
        $base = [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getPatch());
        self::assertNull($transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_PATCH => 'test-not-array'])->getPatch());
        self::assertSame([$patchItemModel], $transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_PATCH => [['test-nested'], 'test-skipped']])->getPatch());
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdTransformer = self::createStub(ExcludedConditionItemIdTransformerInterface::class);
        $excludedConditionItemIdTransformer->method('transform')->willReturn($excludedConditionItemIdModel);
        $transformer = new ExcludedDeviceConditionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedConditionItemIdTransformer);

        $actual = $transformer->transform([ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability']);

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
        $transformer = new ExcludedDeviceConditionConfigEntryTransformer(self::createStub(CapabilityValueTransformerInterface::class), self::createStub(PatchItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class), self::createStub(ExcludedConditionItemIdTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'componentAbsent' => [[ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(ExcludedDeviceConditionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 42], sprintf(ExcludedDeviceConditionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT)];
        yield 'capabilityAbsent' => [[ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(ExcludedDeviceConditionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 42], sprintf(ExcludedDeviceConditionConfigEntryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY)];
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdTransformer = self::createStub(ExcludedConditionItemIdTransformerInterface::class);
        $excludedConditionItemIdTransformer->method('transform')->willReturn($excludedConditionItemIdModel);
        $transformer = new ExcludedDeviceConditionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedConditionItemIdTransformer);
        $base = [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getValues());
        self::assertNull($transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VALUES => 'test-not-array'])->getValues());
        self::assertSame([$capabilityValueModel], $transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VALUES => [['test-nested'], 'test-skipped']])->getValues());
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdTransformer = self::createStub(ExcludedConditionItemIdTransformerInterface::class);
        $excludedConditionItemIdTransformer->method('transform')->willReturn($excludedConditionItemIdModel);
        $transformer = new ExcludedDeviceConditionConfigEntryTransformer($capabilityValueTransformer, $patchItemTransformer, $visibleConditionTransformer, $excludedConditionItemIdTransformer);
        $base = [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_COMPONENT => 'test-component', ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [ExcludedDeviceConditionConfigEntryTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
