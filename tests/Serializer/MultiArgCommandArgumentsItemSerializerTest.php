<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ListForArgumentInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItem;
use ChristianBrown\SmartThings\Model\NumberFieldForArgumentInterface;
use ChristianBrown\SmartThings\Model\SliderForArgumentInterface;
use ChristianBrown\SmartThings\Model\TextFieldForArgumentInterface;
use ChristianBrown\SmartThings\Serializer\ListForArgumentSerializerInterface;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandArgumentsItemSerializer;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandArgumentsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\NumberFieldForArgumentSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderForArgumentSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TextFieldForArgumentSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MultiArgCommandArgumentsItem::class)]
#[CoversClass(MultiArgCommandArgumentsItemSerializer::class)]
final class MultiArgCommandArgumentsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentSerializer = self::createStub(SliderForArgumentSerializerInterface::class);
        $sliderForArgumentSerializer->method('serialize')->willReturn(['test-serialized-slider-for-argument']);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentSerializer = self::createStub(ListForArgumentSerializerInterface::class);
        $listForArgumentSerializer->method('serialize')->willReturn(['test-serialized-list-for-argument']);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentSerializer = self::createStub(TextFieldForArgumentSerializerInterface::class);
        $textFieldForArgumentSerializer->method('serialize')->willReturn(['test-serialized-text-field-for-argument']);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentSerializer = self::createStub(NumberFieldForArgumentSerializerInterface::class);
        $numberFieldForArgumentSerializer->method('serialize')->willReturn(['test-serialized-number-field-for-argument']);
        $model = new MultiArgCommandArgumentsItem('test-label', 'test-display-type');

        $serializer = new MultiArgCommandArgumentsItemSerializer($sliderForArgumentSerializer, $listForArgumentSerializer, $textFieldForArgumentSerializer, $numberFieldForArgumentSerializer);

        self::assertSame(
            [
                MultiArgCommandArgumentsItemSerializerInterface::KEY_LABEL => 'test-label',
                MultiArgCommandArgumentsItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentSerializer = self::createStub(SliderForArgumentSerializerInterface::class);
        $sliderForArgumentSerializer->method('serialize')->willReturn(['test-serialized-slider-for-argument']);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentSerializer = self::createStub(ListForArgumentSerializerInterface::class);
        $listForArgumentSerializer->method('serialize')->willReturn(['test-serialized-list-for-argument']);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentSerializer = self::createStub(TextFieldForArgumentSerializerInterface::class);
        $textFieldForArgumentSerializer->method('serialize')->willReturn(['test-serialized-text-field-for-argument']);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentSerializer = self::createStub(NumberFieldForArgumentSerializerInterface::class);
        $numberFieldForArgumentSerializer->method('serialize')->willReturn(['test-serialized-number-field-for-argument']);
        $model = (new MultiArgCommandArgumentsItem('test-label', 'test-display-type'))
            ->setSlider($sliderForArgumentModel)
            ->setList($listForArgumentModel)
            ->setTextField($textFieldForArgumentModel)
            ->setNumberField($numberFieldForArgumentModel);

        $serializer = new MultiArgCommandArgumentsItemSerializer($sliderForArgumentSerializer, $listForArgumentSerializer, $textFieldForArgumentSerializer, $numberFieldForArgumentSerializer);

        self::assertSame(
            [
                MultiArgCommandArgumentsItemSerializerInterface::KEY_LABEL => 'test-label',
                MultiArgCommandArgumentsItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
                MultiArgCommandArgumentsItemSerializerInterface::KEY_SLIDER => ['test-serialized-slider-for-argument'],
                MultiArgCommandArgumentsItemSerializerInterface::KEY_LIST => ['test-serialized-list-for-argument'],
                MultiArgCommandArgumentsItemSerializerInterface::KEY_TEXT_FIELD => ['test-serialized-text-field-for-argument'],
                MultiArgCommandArgumentsItemSerializerInterface::KEY_NUMBER_FIELD => ['test-serialized-number-field-for-argument'],
            ],
            $serializer->serialize($model)
        );
    }
}
