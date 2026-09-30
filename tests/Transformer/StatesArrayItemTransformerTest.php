<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Model\StatesArrayItem;
use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardStateInterface;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StatesArrayItemTransformer;
use ChristianBrown\SmartThings\Transformer\StatesArrayItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDashboardStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StatesArrayItem::class)]
#[CoversClass(StatesArrayItemTransformer::class)]
final class StatesArrayItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $data = [
            StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label',
            StatesArrayItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            StatesArrayItemTransformerInterface::KEY_VERSION => 7,
            StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component',
            StatesArrayItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
            StatesArrayItemTransformerInterface::KEY_COMPOSITE => true,
            StatesArrayItemTransformerInterface::KEY_GROUP => 'test-group',
            StatesArrayItemTransformerInterface::KEY_FORMAT_INFO => [['test-nested']],
            StatesArrayItemTransformerInterface::KEY_TRANSIENT => true,
        ];

        $transformer = new StatesArrayItemTransformer($alternativeItemTransformer, $visibleConditionForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame($visibleConditionForDashboardStateModel, $actual->getVisibleCondition());
        self::assertTrue($actual->getComposite());
        self::assertSame('test-group', $actual->getGroup());
        self::assertSame([$deviceConfigEntryForDashboardStateFormatInfoItemModel], $actual->getFormatInfo());
        self::assertTrue($actual->getTransient());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $transformer = new StatesArrayItemTransformer($alternativeItemTransformer, $visibleConditionForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);
        $base = [StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [StatesArrayItemTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [StatesArrayItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    public function testTransformFormatInfo(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $transformer = new StatesArrayItemTransformer($alternativeItemTransformer, $visibleConditionForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);
        $base = [StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component'];

        self::assertNull($transformer->transform($base)->getFormatInfo());
        self::assertNull($transformer->transform($base + [StatesArrayItemTransformerInterface::KEY_FORMAT_INFO => 'test-not-array'])->getFormatInfo());
        self::assertSame([$deviceConfigEntryForDashboardStateFormatInfoItemModel], $transformer->transform($base + [StatesArrayItemTransformerInterface::KEY_FORMAT_INFO => [['test-nested'], 'test-skipped']])->getFormatInfo());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new StatesArrayItemTransformer(self::createStub(AlternativeItemTransformerInterface::class), self::createStub(VisibleConditionForDashboardStateTransformerInterface::class), self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getLabel', null];
        yield 'labelWrongType' => [[StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component', StatesArrayItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'capabilityAbsent' => [[StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCapability', null];
        yield 'capabilityWrongType' => [[StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'componentAbsent' => [[StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getComponent', null];
        yield 'componentWrongType' => [[StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StatesArrayItemTransformer(self::createStub(AlternativeItemTransformerInterface::class), self::createStub(VisibleConditionForDashboardStateTransformerInterface::class), self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class));

        $actual = $transformer->transform([StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[StatesArrayItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[StatesArrayItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'compositeAbsent' => [[], 'getComposite', null];
        yield 'compositeWrongType' => [[StatesArrayItemTransformerInterface::KEY_COMPOSITE => 'not-bool'], 'getComposite', null];
        yield 'compositeValid' => [[StatesArrayItemTransformerInterface::KEY_COMPOSITE => true], 'getComposite', true];
        yield 'groupAbsent' => [[], 'getGroup', null];
        yield 'groupWrongType' => [[StatesArrayItemTransformerInterface::KEY_GROUP => 42], 'getGroup', null];
        yield 'groupValid' => [[StatesArrayItemTransformerInterface::KEY_GROUP => 'test-group'], 'getGroup', 'test-group'];
        yield 'transientAbsent' => [[], 'getTransient', null];
        yield 'transientWrongType' => [[StatesArrayItemTransformerInterface::KEY_TRANSIENT => 'not-bool'], 'getTransient', null];
        yield 'transientValid' => [[StatesArrayItemTransformerInterface::KEY_TRANSIENT => true], 'getTransient', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $transformer = new StatesArrayItemTransformer($alternativeItemTransformer, $visibleConditionForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);

        $actual = $transformer->transform([StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component']);

        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getVisibleCondition());
        self::assertNull($actual->getComposite());
        self::assertNull($actual->getGroup());
        self::assertNull($actual->getFormatInfo());
        self::assertNull($actual->getTransient());
    }

    public function testTransformVisibleCondition(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $transformer = new StatesArrayItemTransformer($alternativeItemTransformer, $visibleConditionForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);
        $base = [StatesArrayItemTransformerInterface::KEY_LABEL => 'test-label', StatesArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', StatesArrayItemTransformerInterface::KEY_COMPONENT => 'test-component'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [StatesArrayItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionForDashboardStateModel, $transformer->transform($base + [StatesArrayItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
