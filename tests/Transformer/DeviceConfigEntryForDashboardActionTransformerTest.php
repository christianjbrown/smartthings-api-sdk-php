<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardAction;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInlineInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardActionInlineTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardActionTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardAction::class)]
#[CoversClass(DeviceConfigEntryForDashboardActionTransformer::class)]
final class DeviceConfigEntryForDashboardActionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigEntryForDashboardActionInlineModel = self::createStub(DeviceConfigEntryForDashboardActionInlineInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer = self::createStub(DeviceConfigEntryForDashboardActionInlineTransformerInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionInlineModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 'test-component',
            DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 'test-capability',
            DeviceConfigEntryForDashboardActionTransformerInterface::KEY_VERSION => 7,
            DeviceConfigEntryForDashboardActionTransformerInterface::KEY_IDX => 7,
            DeviceConfigEntryForDashboardActionTransformerInterface::KEY_GROUP => 'test-group',
            DeviceConfigEntryForDashboardActionTransformerInterface::KEY_INLINE => ['test-nested'],
            DeviceConfigEntryForDashboardActionTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new DeviceConfigEntryForDashboardActionTransformer($deviceConfigEntryForDashboardActionInlineTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame(7, $actual->getIdx());
        self::assertSame('test-group', $actual->getGroup());
        self::assertSame($deviceConfigEntryForDashboardActionInlineModel, $actual->getInline());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
    }

    public function testTransformInline(): void
    {
        $deviceConfigEntryForDashboardActionInlineModel = self::createStub(DeviceConfigEntryForDashboardActionInlineInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer = self::createStub(DeviceConfigEntryForDashboardActionInlineTransformerInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionInlineModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new DeviceConfigEntryForDashboardActionTransformer($deviceConfigEntryForDashboardActionInlineTransformer, $visibleConditionTransformer);
        $base = [DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getInline());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDashboardActionTransformerInterface::KEY_INLINE => 'test-not-array'])->getInline());
        self::assertSame($deviceConfigEntryForDashboardActionInlineModel, $transformer->transform($base + [DeviceConfigEntryForDashboardActionTransformerInterface::KEY_INLINE => ['test-nested']])->getInline());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardActionTransformer(self::createStub(DeviceConfigEntryForDashboardActionInlineTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'componentAbsent' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getComponent', null];
        yield 'componentWrongType' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 'test-capability', DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCapability', null];
        yield 'capabilityWrongType' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigEntryForDashboardActionTransformer(self::createStub(DeviceConfigEntryForDashboardActionInlineTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'idxAbsent' => [[], 'getIdx', null];
        yield 'idxWrongType' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_IDX => 'not-int'], 'getIdx', null];
        yield 'idxValid' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_IDX => 7], 'getIdx', 7];
        yield 'groupAbsent' => [[], 'getGroup', null];
        yield 'groupWrongType' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_GROUP => 42], 'getGroup', null];
        yield 'groupValid' => [[DeviceConfigEntryForDashboardActionTransformerInterface::KEY_GROUP => 'test-group'], 'getGroup', 'test-group'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigEntryForDashboardActionInlineModel = self::createStub(DeviceConfigEntryForDashboardActionInlineInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer = self::createStub(DeviceConfigEntryForDashboardActionInlineTransformerInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionInlineModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new DeviceConfigEntryForDashboardActionTransformer($deviceConfigEntryForDashboardActionInlineTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getIdx());
        self::assertNull($actual->getGroup());
        self::assertNull($actual->getInline());
        self::assertNull($actual->getVisibleCondition());
    }

    public function testTransformVisibleCondition(): void
    {
        $deviceConfigEntryForDashboardActionInlineModel = self::createStub(DeviceConfigEntryForDashboardActionInlineInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer = self::createStub(DeviceConfigEntryForDashboardActionInlineTransformerInterface::class);
        $deviceConfigEntryForDashboardActionInlineTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardActionInlineModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new DeviceConfigEntryForDashboardActionTransformer($deviceConfigEntryForDashboardActionInlineTransformer, $visibleConditionTransformer);
        $base = [DeviceConfigEntryForDashboardActionTransformerInterface::KEY_COMPONENT => 'test-component', DeviceConfigEntryForDashboardActionTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [DeviceConfigEntryForDashboardActionTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [DeviceConfigEntryForDashboardActionTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
