<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemActionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemActionsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusItemActionsItem::class)]
#[CoversClass(BasicPlusItemActionsItemTransformer::class)]
final class BasicPlusItemActionsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command',
            BasicPlusItemActionsItemTransformerInterface::KEY_ARGUMENT => 'test-argument',
            BasicPlusItemActionsItemTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            BasicPlusItemActionsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusItemActionsItemTransformerInterface::KEY_VERSION => 7,
            BasicPlusItemActionsItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            BasicPlusItemActionsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
        ];

        $transformer = new BasicPlusItemActionsItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument', $actual->getArgument());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusItemActionsItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getCommand', null];
        yield 'commandWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'componentAbsent' => [[BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getComponent', null];
        yield 'componentWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCapability', null];
        yield 'capabilityWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusItemActionsItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentAbsent' => [[], 'getArgument', null];
        yield 'argumentWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_ARGUMENT => 42], 'getArgument', null];
        yield 'argumentValid' => [[BasicPlusItemActionsItemTransformerInterface::KEY_ARGUMENT => 'test-argument'], 'getArgument', 'test-argument'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[BasicPlusItemActionsItemTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[BasicPlusItemActionsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusItemActionsItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[BasicPlusItemActionsItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[BasicPlusItemActionsItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusItemActionsItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform([BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getArgument());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
    }

    public function testTransformVisibleConditions(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusItemActionsItemTransformer($visibleConditionTransformer);
        $base = [BasicPlusItemActionsItemTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusItemActionsItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusItemActionsItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [BasicPlusItemActionsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [BasicPlusItemActionsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
