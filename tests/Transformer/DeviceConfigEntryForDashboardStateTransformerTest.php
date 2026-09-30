<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardState;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardStateInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForDashboardStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDashboardStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardState::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateTransformer::class)]
final class DeviceConfigEntryForDashboardStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityValueForDashboardStateModel = self::createStub(CapabilityValueForDashboardStateInterface::class);
        $capabilityValueForDashboardStateTransformer = self::createStub(CapabilityValueForDashboardStateTransformerInterface::class);
        $capabilityValueForDashboardStateTransformer->method('transform')->willReturn($capabilityValueForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $data = [
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component',
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability',
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VERSION => 7,
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_IDX => 7,
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_GROUP => 'test-group',
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VALUES => [['test-nested']],
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPOSITE => true,
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_FORMAT_INFO => [['test-nested']],
            DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new DeviceConfigEntryForDashboardStateTransformer($capabilityValueForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer, $visibleConditionForDashboardStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame(7, $actual->getIdx());
        self::assertSame('test-group', $actual->getGroup());
        self::assertSame([$capabilityValueForDashboardStateModel], $actual->getValues());
        self::assertTrue($actual->getComposite());
        self::assertSame([$deviceConfigEntryForDashboardStateFormatInfoItemModel], $actual->getFormatInfo());
        self::assertSame($visibleConditionForDashboardStateModel, $actual->getVisibleCondition());
    }

    public function testTransformFormatInfo(): void
    {
        $capabilityValueForDashboardStateModel = self::createStub(CapabilityValueForDashboardStateInterface::class);
        $capabilityValueForDashboardStateTransformer = self::createStub(CapabilityValueForDashboardStateTransformerInterface::class);
        $capabilityValueForDashboardStateTransformer->method('transform')->willReturn($capabilityValueForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $transformer = new DeviceConfigEntryForDashboardStateTransformer($capabilityValueForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer, $visibleConditionForDashboardStateTransformer);
        $base = [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getFormatInfo());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_FORMAT_INFO => 'test-not-array'])->getFormatInfo());
        self::assertSame([$deviceConfigEntryForDashboardStateFormatInfoItemModel], $transformer->transform($base + [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_FORMAT_INFO => [['test-nested'], 'test-skipped']])->getFormatInfo());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateTransformer(self::createStub(CapabilityValueForDashboardStateTransformerInterface::class), self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class), self::createStub(VisibleConditionForDashboardStateTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'componentAbsent' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getComponent', null];
        yield 'componentWrongType' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability', DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCapability', null];
        yield 'capabilityWrongType' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardStateTransformer(self::createStub(CapabilityValueForDashboardStateTransformerInterface::class), self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class), self::createStub(VisibleConditionForDashboardStateTransformerInterface::class));

        $actual = $transformer->transform([DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'idxAbsent' => [[], 'getIdx', null];
        yield 'idxWrongType' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_IDX => 'not-int'], 'getIdx', null];
        yield 'idxValid' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_IDX => 7], 'getIdx', 7];
        yield 'groupAbsent' => [[], 'getGroup', null];
        yield 'groupWrongType' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_GROUP => 42], 'getGroup', null];
        yield 'groupValid' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_GROUP => 'test-group'], 'getGroup', 'test-group'];
        yield 'compositeAbsent' => [[], 'getComposite', null];
        yield 'compositeWrongType' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPOSITE => 'not-bool'], 'getComposite', null];
        yield 'compositeValid' => [[DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPOSITE => true], 'getComposite', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityValueForDashboardStateModel = self::createStub(CapabilityValueForDashboardStateInterface::class);
        $capabilityValueForDashboardStateTransformer = self::createStub(CapabilityValueForDashboardStateTransformerInterface::class);
        $capabilityValueForDashboardStateTransformer->method('transform')->willReturn($capabilityValueForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $transformer = new DeviceConfigEntryForDashboardStateTransformer($capabilityValueForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer, $visibleConditionForDashboardStateTransformer);

        $actual = $transformer->transform([DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getIdx());
        self::assertNull($actual->getGroup());
        self::assertNull($actual->getValues());
        self::assertNull($actual->getComposite());
        self::assertNull($actual->getFormatInfo());
        self::assertNull($actual->getVisibleCondition());
    }

    public function testTransformValues(): void
    {
        $capabilityValueForDashboardStateModel = self::createStub(CapabilityValueForDashboardStateInterface::class);
        $capabilityValueForDashboardStateTransformer = self::createStub(CapabilityValueForDashboardStateTransformerInterface::class);
        $capabilityValueForDashboardStateTransformer->method('transform')->willReturn($capabilityValueForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $transformer = new DeviceConfigEntryForDashboardStateTransformer($capabilityValueForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer, $visibleConditionForDashboardStateTransformer);
        $base = [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getValues());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VALUES => 'test-not-array'])->getValues());
        self::assertSame([$capabilityValueForDashboardStateModel], $transformer->transform($base + [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VALUES => [['test-nested'], 'test-skipped']])->getValues());
    }

    public function testTransformVisibleCondition(): void
    {
        $capabilityValueForDashboardStateModel = self::createStub(CapabilityValueForDashboardStateInterface::class);
        $capabilityValueForDashboardStateTransformer = self::createStub(CapabilityValueForDashboardStateTransformerInterface::class);
        $capabilityValueForDashboardStateTransformer->method('transform')->willReturn($capabilityValueForDashboardStateModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateTransformer = self::createStub(VisibleConditionForDashboardStateTransformerInterface::class);
        $visibleConditionForDashboardStateTransformer->method('transform')->willReturn($visibleConditionForDashboardStateModel);
        $transformer = new DeviceConfigEntryForDashboardStateTransformer($capabilityValueForDashboardStateTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer, $visibleConditionForDashboardStateTransformer);
        $base = [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionForDashboardStateModel, $transformer->transform($base + [DeviceConfigEntryForDashboardStateTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
