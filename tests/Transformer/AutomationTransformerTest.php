<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ActionListItemInterface;
use ChristianBrown\SmartThings\Model\Automation;
use ChristianBrown\SmartThings\Model\AutomationListItemInterface;
use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;
use ChristianBrown\SmartThings\Transformer\ActionListItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AutomationListItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AutomationTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DescriptionsInAutomationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Automation::class)]
#[CoversClass(AutomationTransformer::class)]
final class AutomationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $automationListItemModel = self::createStub(AutomationListItemInterface::class);
        $automationListItemTransformer = self::createStub(AutomationListItemTransformerInterface::class);
        $automationListItemTransformer->method('transform')->willReturn($automationListItemModel);
        $actionListItemModel = self::createStub(ActionListItemInterface::class);
        $actionListItemTransformer = self::createStub(ActionListItemTransformerInterface::class);
        $actionListItemTransformer->method('transform')->willReturn($actionListItemModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $data = [
            AutomationTransformerInterface::KEY_CONDITIONS => [['test-nested']],
            AutomationTransformerInterface::KEY_ACTIONS => [['test-nested']],
            AutomationTransformerInterface::KEY_DESCRIPTIONS => ['test-nested'],
        ];

        $transformer = new AutomationTransformer($automationListItemTransformer, $actionListItemTransformer, $descriptionsInAutomationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$automationListItemModel], $actual->getConditions());
        self::assertSame([$actionListItemModel], $actual->getActions());
        self::assertSame($descriptionsInAutomationModel, $actual->getDescriptions());
    }

    public function testTransformActions(): void
    {
        $automationListItemModel = self::createStub(AutomationListItemInterface::class);
        $automationListItemTransformer = self::createStub(AutomationListItemTransformerInterface::class);
        $automationListItemTransformer->method('transform')->willReturn($automationListItemModel);
        $actionListItemModel = self::createStub(ActionListItemInterface::class);
        $actionListItemTransformer = self::createStub(ActionListItemTransformerInterface::class);
        $actionListItemTransformer->method('transform')->willReturn($actionListItemModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new AutomationTransformer($automationListItemTransformer, $actionListItemTransformer, $descriptionsInAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [AutomationTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$actionListItemModel], $transformer->transform($base + [AutomationTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformConditions(): void
    {
        $automationListItemModel = self::createStub(AutomationListItemInterface::class);
        $automationListItemTransformer = self::createStub(AutomationListItemTransformerInterface::class);
        $automationListItemTransformer->method('transform')->willReturn($automationListItemModel);
        $actionListItemModel = self::createStub(ActionListItemInterface::class);
        $actionListItemTransformer = self::createStub(ActionListItemTransformerInterface::class);
        $actionListItemTransformer->method('transform')->willReturn($actionListItemModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new AutomationTransformer($automationListItemTransformer, $actionListItemTransformer, $descriptionsInAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getConditions());
        self::assertNull($transformer->transform($base + [AutomationTransformerInterface::KEY_CONDITIONS => 'test-not-array'])->getConditions());
        self::assertSame([$automationListItemModel], $transformer->transform($base + [AutomationTransformerInterface::KEY_CONDITIONS => [['test-nested'], 'test-skipped']])->getConditions());
    }

    public function testTransformDescriptions(): void
    {
        $automationListItemModel = self::createStub(AutomationListItemInterface::class);
        $automationListItemTransformer = self::createStub(AutomationListItemTransformerInterface::class);
        $automationListItemTransformer->method('transform')->willReturn($automationListItemModel);
        $actionListItemModel = self::createStub(ActionListItemInterface::class);
        $actionListItemTransformer = self::createStub(ActionListItemTransformerInterface::class);
        $actionListItemTransformer->method('transform')->willReturn($actionListItemModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new AutomationTransformer($automationListItemTransformer, $actionListItemTransformer, $descriptionsInAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDescriptions());
        self::assertNull($transformer->transform($base + [AutomationTransformerInterface::KEY_DESCRIPTIONS => 'test-not-array'])->getDescriptions());
        self::assertSame($descriptionsInAutomationModel, $transformer->transform($base + [AutomationTransformerInterface::KEY_DESCRIPTIONS => ['test-nested']])->getDescriptions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $automationListItemModel = self::createStub(AutomationListItemInterface::class);
        $automationListItemTransformer = self::createStub(AutomationListItemTransformerInterface::class);
        $automationListItemTransformer->method('transform')->willReturn($automationListItemModel);
        $actionListItemModel = self::createStub(ActionListItemInterface::class);
        $actionListItemTransformer = self::createStub(ActionListItemTransformerInterface::class);
        $actionListItemTransformer->method('transform')->willReturn($actionListItemModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new AutomationTransformer($automationListItemTransformer, $actionListItemTransformer, $descriptionsInAutomationTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getConditions());
        self::assertNull($actual->getActions());
        self::assertNull($actual->getDescriptions());
    }
}
