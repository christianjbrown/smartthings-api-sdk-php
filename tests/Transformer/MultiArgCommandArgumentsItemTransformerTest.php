<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ListForArgumentInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItem;
use ChristianBrown\SmartThings\Model\NumberFieldForArgumentInterface;
use ChristianBrown\SmartThings\Model\SliderForArgumentInterface;
use ChristianBrown\SmartThings\Model\TextFieldForArgumentInterface;
use ChristianBrown\SmartThings\Transformer\ListForArgumentTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandArgumentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandArgumentsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldForArgumentTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForArgumentTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextFieldForArgumentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MultiArgCommandArgumentsItem::class)]
#[CoversClass(MultiArgCommandArgumentsItemTransformer::class)]
final class MultiArgCommandArgumentsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentTransformer = self::createStub(SliderForArgumentTransformerInterface::class);
        $sliderForArgumentTransformer->method('transform')->willReturn($sliderForArgumentModel);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentTransformer = self::createStub(ListForArgumentTransformerInterface::class);
        $listForArgumentTransformer->method('transform')->willReturn($listForArgumentModel);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentTransformer = self::createStub(TextFieldForArgumentTransformerInterface::class);
        $textFieldForArgumentTransformer->method('transform')->willReturn($textFieldForArgumentModel);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentTransformer = self::createStub(NumberFieldForArgumentTransformerInterface::class);
        $numberFieldForArgumentTransformer->method('transform')->willReturn($numberFieldForArgumentModel);
        $data = [
            MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label',
            MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            MultiArgCommandArgumentsItemTransformerInterface::KEY_SLIDER => ['test-nested'],
            MultiArgCommandArgumentsItemTransformerInterface::KEY_LIST => ['test-nested'],
            MultiArgCommandArgumentsItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested'],
            MultiArgCommandArgumentsItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested'],
        ];

        $transformer = new MultiArgCommandArgumentsItemTransformer($sliderForArgumentTransformer, $listForArgumentTransformer, $textFieldForArgumentTransformer, $numberFieldForArgumentTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($sliderForArgumentModel, $actual->getSlider());
        self::assertSame($listForArgumentModel, $actual->getList());
        self::assertSame($textFieldForArgumentModel, $actual->getTextField());
        self::assertSame($numberFieldForArgumentModel, $actual->getNumberField());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new MultiArgCommandArgumentsItemTransformer(self::createStub(SliderForArgumentTransformerInterface::class), self::createStub(ListForArgumentTransformerInterface::class), self::createStub(TextFieldForArgumentTransformerInterface::class), self::createStub(NumberFieldForArgumentTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], 'getLabel', null];
        yield 'labelWrongType' => [[MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'displayTypeAbsent' => [[MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label'], 'getDisplayType', null];
        yield 'displayTypeWrongType' => [[MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label', MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 42], 'getDisplayType', null];
    }

    public function testTransformList(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentTransformer = self::createStub(SliderForArgumentTransformerInterface::class);
        $sliderForArgumentTransformer->method('transform')->willReturn($sliderForArgumentModel);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentTransformer = self::createStub(ListForArgumentTransformerInterface::class);
        $listForArgumentTransformer->method('transform')->willReturn($listForArgumentModel);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentTransformer = self::createStub(TextFieldForArgumentTransformerInterface::class);
        $textFieldForArgumentTransformer->method('transform')->willReturn($textFieldForArgumentModel);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentTransformer = self::createStub(NumberFieldForArgumentTransformerInterface::class);
        $numberFieldForArgumentTransformer->method('transform')->willReturn($numberFieldForArgumentModel);
        $transformer = new MultiArgCommandArgumentsItemTransformer($sliderForArgumentTransformer, $listForArgumentTransformer, $textFieldForArgumentTransformer, $numberFieldForArgumentTransformer);
        $base = [MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label', MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listForArgumentModel, $transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_LIST => ['test-nested']])->getList());
    }

    public function testTransformNumberField(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentTransformer = self::createStub(SliderForArgumentTransformerInterface::class);
        $sliderForArgumentTransformer->method('transform')->willReturn($sliderForArgumentModel);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentTransformer = self::createStub(ListForArgumentTransformerInterface::class);
        $listForArgumentTransformer->method('transform')->willReturn($listForArgumentModel);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentTransformer = self::createStub(TextFieldForArgumentTransformerInterface::class);
        $textFieldForArgumentTransformer->method('transform')->willReturn($textFieldForArgumentModel);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentTransformer = self::createStub(NumberFieldForArgumentTransformerInterface::class);
        $numberFieldForArgumentTransformer->method('transform')->willReturn($numberFieldForArgumentModel);
        $transformer = new MultiArgCommandArgumentsItemTransformer($sliderForArgumentTransformer, $listForArgumentTransformer, $textFieldForArgumentTransformer, $numberFieldForArgumentTransformer);
        $base = [MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label', MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getNumberField());
        self::assertNull($transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_NUMBER_FIELD => 'test-not-array'])->getNumberField());
        self::assertSame($numberFieldForArgumentModel, $transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested']])->getNumberField());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentTransformer = self::createStub(SliderForArgumentTransformerInterface::class);
        $sliderForArgumentTransformer->method('transform')->willReturn($sliderForArgumentModel);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentTransformer = self::createStub(ListForArgumentTransformerInterface::class);
        $listForArgumentTransformer->method('transform')->willReturn($listForArgumentModel);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentTransformer = self::createStub(TextFieldForArgumentTransformerInterface::class);
        $textFieldForArgumentTransformer->method('transform')->willReturn($textFieldForArgumentModel);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentTransformer = self::createStub(NumberFieldForArgumentTransformerInterface::class);
        $numberFieldForArgumentTransformer->method('transform')->willReturn($numberFieldForArgumentModel);
        $transformer = new MultiArgCommandArgumentsItemTransformer($sliderForArgumentTransformer, $listForArgumentTransformer, $textFieldForArgumentTransformer, $numberFieldForArgumentTransformer);

        $actual = $transformer->transform([MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label', MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getSlider());
        self::assertNull($actual->getList());
        self::assertNull($actual->getTextField());
        self::assertNull($actual->getNumberField());
    }

    public function testTransformSlider(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentTransformer = self::createStub(SliderForArgumentTransformerInterface::class);
        $sliderForArgumentTransformer->method('transform')->willReturn($sliderForArgumentModel);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentTransformer = self::createStub(ListForArgumentTransformerInterface::class);
        $listForArgumentTransformer->method('transform')->willReturn($listForArgumentModel);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentTransformer = self::createStub(TextFieldForArgumentTransformerInterface::class);
        $textFieldForArgumentTransformer->method('transform')->willReturn($textFieldForArgumentModel);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentTransformer = self::createStub(NumberFieldForArgumentTransformerInterface::class);
        $numberFieldForArgumentTransformer->method('transform')->willReturn($numberFieldForArgumentModel);
        $transformer = new MultiArgCommandArgumentsItemTransformer($sliderForArgumentTransformer, $listForArgumentTransformer, $textFieldForArgumentTransformer, $numberFieldForArgumentTransformer);
        $base = [MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label', MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderForArgumentModel, $transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
    }

    public function testTransformTextField(): void
    {
        $sliderForArgumentModel = self::createStub(SliderForArgumentInterface::class);
        $sliderForArgumentTransformer = self::createStub(SliderForArgumentTransformerInterface::class);
        $sliderForArgumentTransformer->method('transform')->willReturn($sliderForArgumentModel);
        $listForArgumentModel = self::createStub(ListForArgumentInterface::class);
        $listForArgumentTransformer = self::createStub(ListForArgumentTransformerInterface::class);
        $listForArgumentTransformer->method('transform')->willReturn($listForArgumentModel);
        $textFieldForArgumentModel = self::createStub(TextFieldForArgumentInterface::class);
        $textFieldForArgumentTransformer = self::createStub(TextFieldForArgumentTransformerInterface::class);
        $textFieldForArgumentTransformer->method('transform')->willReturn($textFieldForArgumentModel);
        $numberFieldForArgumentModel = self::createStub(NumberFieldForArgumentInterface::class);
        $numberFieldForArgumentTransformer = self::createStub(NumberFieldForArgumentTransformerInterface::class);
        $numberFieldForArgumentTransformer->method('transform')->willReturn($numberFieldForArgumentModel);
        $transformer = new MultiArgCommandArgumentsItemTransformer($sliderForArgumentTransformer, $listForArgumentTransformer, $textFieldForArgumentTransformer, $numberFieldForArgumentTransformer);
        $base = [MultiArgCommandArgumentsItemTransformerInterface::KEY_LABEL => 'test-label', MultiArgCommandArgumentsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTextField());
        self::assertNull($transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_TEXT_FIELD => 'test-not-array'])->getTextField());
        self::assertSame($textFieldForArgumentModel, $transformer->transform($base + [MultiArgCommandArgumentsItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested']])->getTextField());
    }
}
