<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItem;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityActionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityActionsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListForAutomationActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionBaseSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutomationForCapabilityActionsItem::class)]
#[CoversClass(AutomationForCapabilityActionsItemSerializer::class)]
final class AutomationForCapabilityActionsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionSerializer = self::createStub(SliderForAutomationActionSerializerInterface::class);
        $sliderForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-slider-for-automation-action']);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionSerializer = self::createStub(ListForAutomationActionSerializerInterface::class);
        $listForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-list-for-automation-action']);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionSerializer = self::createStub(DynamicListForAutomationActionSerializerInterface::class);
        $dynamicListForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-dynamic-list-for-automation-action']);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionSerializer = self::createStub(TextFieldForAutomationActionSerializerInterface::class);
        $textFieldForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-text-field-for-automation-action']);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionSerializer = self::createStub(NumberFieldForAutomationActionSerializerInterface::class);
        $numberFieldForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-number-field-for-automation-action']);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandSerializer = self::createStub(MultiArgCommandSerializerInterface::class);
        $multiArgCommandSerializer->method('serialize')->willReturn(['test-serialized-multi-arg-command']);
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseSerializer = self::createStub(VisibleConditionBaseSerializerInterface::class);
        $visibleConditionBaseSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-base']);
        $model = new AutomationForCapabilityActionsItem('test-label', 'test-display-type');

        $serializer = new AutomationForCapabilityActionsItemSerializer($sliderForAutomationActionSerializer, $listForAutomationActionSerializer, $dynamicListForAutomationActionSerializer, $textFieldForAutomationActionSerializer, $numberFieldForAutomationActionSerializer, $multiArgCommandSerializer, $visibleConditionBaseSerializer);

        self::assertSame(
            [
                AutomationForCapabilityActionsItemSerializerInterface::KEY_LABEL => 'test-label',
                AutomationForCapabilityActionsItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionSerializer = self::createStub(SliderForAutomationActionSerializerInterface::class);
        $sliderForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-slider-for-automation-action']);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionSerializer = self::createStub(ListForAutomationActionSerializerInterface::class);
        $listForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-list-for-automation-action']);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionSerializer = self::createStub(DynamicListForAutomationActionSerializerInterface::class);
        $dynamicListForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-dynamic-list-for-automation-action']);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionSerializer = self::createStub(TextFieldForAutomationActionSerializerInterface::class);
        $textFieldForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-text-field-for-automation-action']);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionSerializer = self::createStub(NumberFieldForAutomationActionSerializerInterface::class);
        $numberFieldForAutomationActionSerializer->method('serialize')->willReturn(['test-serialized-number-field-for-automation-action']);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandSerializer = self::createStub(MultiArgCommandSerializerInterface::class);
        $multiArgCommandSerializer->method('serialize')->willReturn(['test-serialized-multi-arg-command']);
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseSerializer = self::createStub(VisibleConditionBaseSerializerInterface::class);
        $visibleConditionBaseSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-base']);
        $model = (new AutomationForCapabilityActionsItem('test-label', 'test-display-type'))
            ->setDescription('test-description')
            ->setSlider($sliderForAutomationActionModel)
            ->setList($listForAutomationActionModel)
            ->setDynamicList($dynamicListForAutomationActionModel)
            ->setTextField($textFieldForAutomationActionModel)
            ->setNumberField($numberFieldForAutomationActionModel)
            ->setMultiArgCommand($multiArgCommandModel)
            ->setEmphasis(true)
            ->setVisibleCondition($visibleConditionBaseModel);

        $serializer = new AutomationForCapabilityActionsItemSerializer($sliderForAutomationActionSerializer, $listForAutomationActionSerializer, $dynamicListForAutomationActionSerializer, $textFieldForAutomationActionSerializer, $numberFieldForAutomationActionSerializer, $multiArgCommandSerializer, $visibleConditionBaseSerializer);

        self::assertSame(
            [
                AutomationForCapabilityActionsItemSerializerInterface::KEY_LABEL => 'test-label',
                AutomationForCapabilityActionsItemSerializerInterface::KEY_DESCRIPTION => 'test-description',
                AutomationForCapabilityActionsItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
                AutomationForCapabilityActionsItemSerializerInterface::KEY_SLIDER => ['test-serialized-slider-for-automation-action'],
                AutomationForCapabilityActionsItemSerializerInterface::KEY_LIST => ['test-serialized-list-for-automation-action'],
                AutomationForCapabilityActionsItemSerializerInterface::KEY_DYNAMIC_LIST => ['test-serialized-dynamic-list-for-automation-action'],
                AutomationForCapabilityActionsItemSerializerInterface::KEY_TEXT_FIELD => ['test-serialized-text-field-for-automation-action'],
                AutomationForCapabilityActionsItemSerializerInterface::KEY_NUMBER_FIELD => ['test-serialized-number-field-for-automation-action'],
                AutomationForCapabilityActionsItemSerializerInterface::KEY_MULTI_ARG_COMMAND => ['test-serialized-multi-arg-command'],
                AutomationForCapabilityActionsItemSerializerInterface::KEY_EMPHASIS => true,
                AutomationForCapabilityActionsItemSerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition-base'],
            ],
            $serializer->serialize($model)
        );
    }
}
