<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItem;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityConditionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityConditionsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionBaseSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutomationForCapabilityConditionsItem::class)]
#[CoversClass(AutomationForCapabilityConditionsItemSerializer::class)]
final class AutomationForCapabilityConditionsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionSerializer = self::createStub(SliderForAutomationConditionSerializerInterface::class);
        $sliderForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-slider-for-automation-condition']);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionSerializer = self::createStub(ListForAutomationConditionSerializerInterface::class);
        $listForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-list-for-automation-condition']);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionSerializer = self::createStub(DynamicListForAutomationConditionSerializerInterface::class);
        $dynamicListForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-dynamic-list-for-automation-condition']);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionSerializer = self::createStub(NumberFieldForAutomationConditionSerializerInterface::class);
        $numberFieldForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-number-field-for-automation-condition']);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionSerializer = self::createStub(TextFieldForAutomationConditionSerializerInterface::class);
        $textFieldForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-text-field-for-automation-condition']);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionSerializer = self::createStub(EnumSliderForAutomationConditionSerializerInterface::class);
        $enumSliderForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-enum-slider-for-automation-condition']);
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseSerializer = self::createStub(VisibleConditionBaseSerializerInterface::class);
        $visibleConditionBaseSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-base']);
        $model = new AutomationForCapabilityConditionsItem('test-label', 'test-display-type');

        $serializer = new AutomationForCapabilityConditionsItemSerializer($sliderForAutomationConditionSerializer, $listForAutomationConditionSerializer, $dynamicListForAutomationConditionSerializer, $numberFieldForAutomationConditionSerializer, $textFieldForAutomationConditionSerializer, $enumSliderForAutomationConditionSerializer, $visibleConditionBaseSerializer);

        self::assertSame(
            [
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_LABEL => 'test-label',
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionSerializer = self::createStub(SliderForAutomationConditionSerializerInterface::class);
        $sliderForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-slider-for-automation-condition']);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionSerializer = self::createStub(ListForAutomationConditionSerializerInterface::class);
        $listForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-list-for-automation-condition']);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionSerializer = self::createStub(DynamicListForAutomationConditionSerializerInterface::class);
        $dynamicListForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-dynamic-list-for-automation-condition']);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionSerializer = self::createStub(NumberFieldForAutomationConditionSerializerInterface::class);
        $numberFieldForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-number-field-for-automation-condition']);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionSerializer = self::createStub(TextFieldForAutomationConditionSerializerInterface::class);
        $textFieldForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-text-field-for-automation-condition']);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionSerializer = self::createStub(EnumSliderForAutomationConditionSerializerInterface::class);
        $enumSliderForAutomationConditionSerializer->method('serialize')->willReturn(['test-serialized-enum-slider-for-automation-condition']);
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseSerializer = self::createStub(VisibleConditionBaseSerializerInterface::class);
        $visibleConditionBaseSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-base']);
        $model = (new AutomationForCapabilityConditionsItem('test-label', 'test-display-type'))
            ->setDescription('test-description')
            ->setSlider($sliderForAutomationConditionModel)
            ->setList($listForAutomationConditionModel)
            ->setDynamicList($dynamicListForAutomationConditionModel)
            ->setNumberField($numberFieldForAutomationConditionModel)
            ->setTextField($textFieldForAutomationConditionModel)
            ->setEnumSlider($enumSliderForAutomationConditionModel)
            ->setEmphasis(true)
            ->setVisibleCondition($visibleConditionBaseModel);

        $serializer = new AutomationForCapabilityConditionsItemSerializer($sliderForAutomationConditionSerializer, $listForAutomationConditionSerializer, $dynamicListForAutomationConditionSerializer, $numberFieldForAutomationConditionSerializer, $textFieldForAutomationConditionSerializer, $enumSliderForAutomationConditionSerializer, $visibleConditionBaseSerializer);

        self::assertSame(
            [
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_LABEL => 'test-label',
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_DESCRIPTION => 'test-description',
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_SLIDER => ['test-serialized-slider-for-automation-condition'],
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_LIST => ['test-serialized-list-for-automation-condition'],
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_DYNAMIC_LIST => ['test-serialized-dynamic-list-for-automation-condition'],
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_NUMBER_FIELD => ['test-serialized-number-field-for-automation-condition'],
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_TEXT_FIELD => ['test-serialized-text-field-for-automation-condition'],
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_ENUM_SLIDER => ['test-serialized-enum-slider-for-automation-condition'],
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_EMPHASIS => true,
                AutomationForCapabilityConditionsItemSerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition-base'],
            ],
            $serializer->serialize($model)
        );
    }
}
