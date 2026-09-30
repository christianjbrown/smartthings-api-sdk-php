<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueForPanelInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForPanelTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigItemsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigItemsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PanelForDeviceConfigItemsItem::class)]
#[CoversClass(PanelForDeviceConfigItemsItemTransformer::class)]
final class PanelForDeviceConfigItemsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityValueForPanelModel = self::createStub(CapabilityValueForPanelInterface::class);
        $capabilityValueForPanelTransformer = self::createStub(CapabilityValueForPanelTransformerInterface::class);
        $capabilityValueForPanelTransformer->method('transform')->willReturn($capabilityValueForPanelModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component',
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_VERSION => 7,
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_IDX => 7,
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size',
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_VALUES => [['test-nested']],
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
            PanelForDeviceConfigItemsItemTransformerInterface::KEY_HIDE_ON_UNMATCH => true,
        ];

        $transformer = new PanelForDeviceConfigItemsItemTransformer($capabilityValueForPanelTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame(7, $actual->getIdx());
        self::assertSame('test-size', $actual->getSize());
        self::assertSame([$capabilityValueForPanelModel], $actual->getValues());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
        self::assertTrue($actual->getHideOnUnmatch());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PanelForDeviceConfigItemsItemTransformer(self::createStub(CapabilityValueForPanelTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'componentAbsent' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size'], 'getComponent', null];
        yield 'componentWrongType' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size', PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size'], 'getCapability', null];
        yield 'capabilityWrongType' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size', PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'sizeAbsent' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getSize', null];
        yield 'sizeWrongType' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 42], 'getSize', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PanelForDeviceConfigItemsItemTransformer(self::createStub(CapabilityValueForPanelTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'idxAbsent' => [[], 'getIdx', null];
        yield 'idxWrongType' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_IDX => 'not-int'], 'getIdx', null];
        yield 'idxValid' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_IDX => 7], 'getIdx', 7];
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
        yield 'hideOnUnmatchAbsent' => [[], 'getHideOnUnmatch', null];
        yield 'hideOnUnmatchWrongType' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_HIDE_ON_UNMATCH => 'not-bool'], 'getHideOnUnmatch', null];
        yield 'hideOnUnmatchValid' => [[PanelForDeviceConfigItemsItemTransformerInterface::KEY_HIDE_ON_UNMATCH => true], 'getHideOnUnmatch', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityValueForPanelModel = self::createStub(CapabilityValueForPanelInterface::class);
        $capabilityValueForPanelTransformer = self::createStub(CapabilityValueForPanelTransformerInterface::class);
        $capabilityValueForPanelTransformer->method('transform')->willReturn($capabilityValueForPanelModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDeviceConfigItemsItemTransformer($capabilityValueForPanelTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getIdx());
        self::assertNull($actual->getValues());
        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
        self::assertNull($actual->getHideOnUnmatch());
    }

    public function testTransformValues(): void
    {
        $capabilityValueForPanelModel = self::createStub(CapabilityValueForPanelInterface::class);
        $capabilityValueForPanelTransformer = self::createStub(CapabilityValueForPanelTransformerInterface::class);
        $capabilityValueForPanelTransformer->method('transform')->willReturn($capabilityValueForPanelModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDeviceConfigItemsItemTransformer($capabilityValueForPanelTransformer, $visibleConditionTransformer);
        $base = [PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size'];

        self::assertNull($transformer->transform($base)->getValues());
        self::assertNull($transformer->transform($base + [PanelForDeviceConfigItemsItemTransformerInterface::KEY_VALUES => 'test-not-array'])->getValues());
        self::assertSame([$capabilityValueForPanelModel], $transformer->transform($base + [PanelForDeviceConfigItemsItemTransformerInterface::KEY_VALUES => [['test-nested'], 'test-skipped']])->getValues());
    }

    public function testTransformVisibleConditions(): void
    {
        $capabilityValueForPanelModel = self::createStub(CapabilityValueForPanelInterface::class);
        $capabilityValueForPanelTransformer = self::createStub(CapabilityValueForPanelTransformerInterface::class);
        $capabilityValueForPanelTransformer->method('transform')->willReturn($capabilityValueForPanelModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDeviceConfigItemsItemTransformer($capabilityValueForPanelTransformer, $visibleConditionTransformer);
        $base = [PanelForDeviceConfigItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDeviceConfigItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDeviceConfigItemsItemTransformerInterface::KEY_SIZE => 'test-size'];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [PanelForDeviceConfigItemsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [PanelForDeviceConfigItemsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
