<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AutomationForCapability;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItemInterface;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItemInterface;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityActionsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityConditionsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutomationForCapability::class)]
#[CoversClass(AutomationForCapabilityTransformer::class)]
final class AutomationForCapabilityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $automationForCapabilityConditionsItemModel = self::createStub(AutomationForCapabilityConditionsItemInterface::class);
        $automationForCapabilityConditionsItemTransformer = self::createStub(AutomationForCapabilityConditionsItemTransformerInterface::class);
        $automationForCapabilityConditionsItemTransformer->method('transform')->willReturn($automationForCapabilityConditionsItemModel);
        $automationForCapabilityActionsItemModel = self::createStub(AutomationForCapabilityActionsItemInterface::class);
        $automationForCapabilityActionsItemTransformer = self::createStub(AutomationForCapabilityActionsItemTransformerInterface::class);
        $automationForCapabilityActionsItemTransformer->method('transform')->willReturn($automationForCapabilityActionsItemModel);
        $data = [
            AutomationForCapabilityTransformerInterface::KEY_CONDITIONS => [['test-nested']],
            AutomationForCapabilityTransformerInterface::KEY_ACTIONS => [['test-nested']],
        ];

        $transformer = new AutomationForCapabilityTransformer($automationForCapabilityConditionsItemTransformer, $automationForCapabilityActionsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$automationForCapabilityConditionsItemModel], $actual->getConditions());
        self::assertSame([$automationForCapabilityActionsItemModel], $actual->getActions());
    }

    public function testTransformActions(): void
    {
        $automationForCapabilityConditionsItemModel = self::createStub(AutomationForCapabilityConditionsItemInterface::class);
        $automationForCapabilityConditionsItemTransformer = self::createStub(AutomationForCapabilityConditionsItemTransformerInterface::class);
        $automationForCapabilityConditionsItemTransformer->method('transform')->willReturn($automationForCapabilityConditionsItemModel);
        $automationForCapabilityActionsItemModel = self::createStub(AutomationForCapabilityActionsItemInterface::class);
        $automationForCapabilityActionsItemTransformer = self::createStub(AutomationForCapabilityActionsItemTransformerInterface::class);
        $automationForCapabilityActionsItemTransformer->method('transform')->willReturn($automationForCapabilityActionsItemModel);
        $transformer = new AutomationForCapabilityTransformer($automationForCapabilityConditionsItemTransformer, $automationForCapabilityActionsItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$automationForCapabilityActionsItemModel], $transformer->transform($base + [AutomationForCapabilityTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformConditions(): void
    {
        $automationForCapabilityConditionsItemModel = self::createStub(AutomationForCapabilityConditionsItemInterface::class);
        $automationForCapabilityConditionsItemTransformer = self::createStub(AutomationForCapabilityConditionsItemTransformerInterface::class);
        $automationForCapabilityConditionsItemTransformer->method('transform')->willReturn($automationForCapabilityConditionsItemModel);
        $automationForCapabilityActionsItemModel = self::createStub(AutomationForCapabilityActionsItemInterface::class);
        $automationForCapabilityActionsItemTransformer = self::createStub(AutomationForCapabilityActionsItemTransformerInterface::class);
        $automationForCapabilityActionsItemTransformer->method('transform')->willReturn($automationForCapabilityActionsItemModel);
        $transformer = new AutomationForCapabilityTransformer($automationForCapabilityConditionsItemTransformer, $automationForCapabilityActionsItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getConditions());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityTransformerInterface::KEY_CONDITIONS => 'test-not-array'])->getConditions());
        self::assertSame([$automationForCapabilityConditionsItemModel], $transformer->transform($base + [AutomationForCapabilityTransformerInterface::KEY_CONDITIONS => [['test-nested'], 'test-skipped']])->getConditions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $automationForCapabilityConditionsItemModel = self::createStub(AutomationForCapabilityConditionsItemInterface::class);
        $automationForCapabilityConditionsItemTransformer = self::createStub(AutomationForCapabilityConditionsItemTransformerInterface::class);
        $automationForCapabilityConditionsItemTransformer->method('transform')->willReturn($automationForCapabilityConditionsItemModel);
        $automationForCapabilityActionsItemModel = self::createStub(AutomationForCapabilityActionsItemInterface::class);
        $automationForCapabilityActionsItemTransformer = self::createStub(AutomationForCapabilityActionsItemTransformerInterface::class);
        $automationForCapabilityActionsItemTransformer->method('transform')->willReturn($automationForCapabilityActionsItemModel);
        $transformer = new AutomationForCapabilityTransformer($automationForCapabilityConditionsItemTransformer, $automationForCapabilityActionsItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getConditions());
        self::assertNull($actual->getActions());
    }
}
