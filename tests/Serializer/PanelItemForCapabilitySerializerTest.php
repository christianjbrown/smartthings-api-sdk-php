<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\EmptyWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\PanelItemForCapability;
use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\SliderWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StateWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Serializer\EmptyWithAvailableSizeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PanelItemForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\PanelItemForCapabilitySerializerInterface;
use ChristianBrown\SmartThings\Serializer\PushButtonWithAvailableSizeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderWithAvailableSizeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StateWithAvailableSizeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PanelItemForCapability::class)]
#[CoversClass(PanelItemForCapabilitySerializer::class)]
final class PanelItemForCapabilitySerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeSerializer = self::createStub(StepperWithAvailableSizeSerializerInterface::class);
        $stepperWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size']);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeSerializer = self::createStub(ListWithAvailableSizeSerializerInterface::class);
        $listWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size']);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeSerializer = self::createStub(PushButtonWithAvailableSizeSerializerInterface::class);
        $pushButtonWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-push-button-with-available-size']);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeSerializer = self::createStub(StateWithAvailableSizeSerializerInterface::class);
        $stateWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-state-with-available-size']);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeSerializer = self::createStub(SliderWithAvailableSizeSerializerInterface::class);
        $sliderWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-slider-with-available-size']);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeSerializer = self::createStub(EmptyWithAvailableSizeSerializerInterface::class);
        $emptyWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-empty-with-available-size']);
        $model = new PanelItemForCapability('test-display-type');

        $serializer = new PanelItemForCapabilitySerializer($stepperWithAvailableSizeSerializer, $listWithAvailableSizeSerializer, $pushButtonWithAvailableSizeSerializer, $stateWithAvailableSizeSerializer, $sliderWithAvailableSizeSerializer, $emptyWithAvailableSizeSerializer);

        self::assertSame(
            [
                PanelItemForCapabilitySerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeSerializer = self::createStub(StepperWithAvailableSizeSerializerInterface::class);
        $stepperWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size']);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeSerializer = self::createStub(ListWithAvailableSizeSerializerInterface::class);
        $listWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size']);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeSerializer = self::createStub(PushButtonWithAvailableSizeSerializerInterface::class);
        $pushButtonWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-push-button-with-available-size']);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeSerializer = self::createStub(StateWithAvailableSizeSerializerInterface::class);
        $stateWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-state-with-available-size']);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeSerializer = self::createStub(SliderWithAvailableSizeSerializerInterface::class);
        $sliderWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-slider-with-available-size']);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeSerializer = self::createStub(EmptyWithAvailableSizeSerializerInterface::class);
        $emptyWithAvailableSizeSerializer->method('serialize')->willReturn(['test-serialized-empty-with-available-size']);
        $model = (new PanelItemForCapability('test-display-type'))
            ->setLabel('test-label')
            ->setStepper($stepperWithAvailableSizeModel)
            ->setList($listWithAvailableSizeModel)
            ->setPushButton($pushButtonWithAvailableSizeModel)
            ->setState($stateWithAvailableSizeModel)
            ->setSlider($sliderWithAvailableSizeModel)
            ->setEmpty($emptyWithAvailableSizeModel);

        $serializer = new PanelItemForCapabilitySerializer($stepperWithAvailableSizeSerializer, $listWithAvailableSizeSerializer, $pushButtonWithAvailableSizeSerializer, $stateWithAvailableSizeSerializer, $sliderWithAvailableSizeSerializer, $emptyWithAvailableSizeSerializer);

        self::assertSame(
            [
                PanelItemForCapabilitySerializerInterface::KEY_LABEL => 'test-label',
                PanelItemForCapabilitySerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
                PanelItemForCapabilitySerializerInterface::KEY_STEPPER => ['test-serialized-stepper-with-available-size'],
                PanelItemForCapabilitySerializerInterface::KEY_LIST => ['test-serialized-list-with-available-size'],
                PanelItemForCapabilitySerializerInterface::KEY_PUSH_BUTTON => ['test-serialized-push-button-with-available-size'],
                PanelItemForCapabilitySerializerInterface::KEY_STATE => ['test-serialized-state-with-available-size'],
                PanelItemForCapabilitySerializerInterface::KEY_SLIDER => ['test-serialized-slider-with-available-size'],
                PanelItemForCapabilitySerializerInterface::KEY_EMPTY => ['test-serialized-empty-with-available-size'],
            ],
            $serializer->serialize($model)
        );
    }
}
