<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EmptyWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\PanelItemForCapability;
use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\SliderWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StateWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Transformer\EmptyWithAvailableSizeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PanelItemForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\PanelItemForCapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PushButtonWithAvailableSizeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderWithAvailableSizeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StateWithAvailableSizeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PanelItemForCapability::class)]
#[CoversClass(PanelItemForCapabilityTransformer::class)]
final class PanelItemForCapabilityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $data = [
            PanelItemForCapabilityTransformerInterface::KEY_LABEL => 'test-label',
            PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            PanelItemForCapabilityTransformerInterface::KEY_STEPPER => ['test-nested'],
            PanelItemForCapabilityTransformerInterface::KEY_LIST => ['test-nested'],
            PanelItemForCapabilityTransformerInterface::KEY_PUSH_BUTTON => ['test-nested'],
            PanelItemForCapabilityTransformerInterface::KEY_STATE => ['test-nested'],
            PanelItemForCapabilityTransformerInterface::KEY_SLIDER => ['test-nested'],
            PanelItemForCapabilityTransformerInterface::KEY_EMPTY => ['test-nested'],
        ];

        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($stepperWithAvailableSizeModel, $actual->getStepper());
        self::assertSame($listWithAvailableSizeModel, $actual->getList());
        self::assertSame($pushButtonWithAvailableSizeModel, $actual->getPushButton());
        self::assertSame($stateWithAvailableSizeModel, $actual->getState());
        self::assertSame($sliderWithAvailableSizeModel, $actual->getSlider());
        self::assertSame($emptyWithAvailableSizeModel, $actual->getEmpty());
    }

    public function testTransformEmpty(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);
        $base = [PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getEmpty());
        self::assertNull($transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_EMPTY => 'test-not-array'])->getEmpty());
        self::assertSame($emptyWithAvailableSizeModel, $transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_EMPTY => ['test-nested']])->getEmpty());
    }

    public function testTransformList(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);
        $base = [PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listWithAvailableSizeModel, $transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_LIST => ['test-nested']])->getList());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PanelItemForCapabilityTransformer(self::createStub(StepperWithAvailableSizeTransformerInterface::class), self::createStub(ListWithAvailableSizeTransformerInterface::class), self::createStub(PushButtonWithAvailableSizeTransformerInterface::class), self::createStub(StateWithAvailableSizeTransformerInterface::class), self::createStub(SliderWithAvailableSizeTransformerInterface::class), self::createStub(EmptyWithAvailableSizeTransformerInterface::class));

        $actual = $transformer->transform([PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[PanelItemForCapabilityTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[PanelItemForCapabilityTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
    }

    public function testTransformPushButton(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);
        $base = [PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPushButton());
        self::assertNull($transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_PUSH_BUTTON => 'test-not-array'])->getPushButton());
        self::assertSame($pushButtonWithAvailableSizeModel, $transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_PUSH_BUTTON => ['test-nested']])->getPushButton());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);

        $actual = $transformer->transform([PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getLabel());
        self::assertNull($actual->getStepper());
        self::assertNull($actual->getList());
        self::assertNull($actual->getPushButton());
        self::assertNull($actual->getState());
        self::assertNull($actual->getSlider());
        self::assertNull($actual->getEmpty());
    }

    public function testTransformSlider(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);
        $base = [PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderWithAvailableSizeModel, $transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
    }

    public function testTransformState(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);
        $base = [PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($stateWithAvailableSizeModel, $transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }

    public function testTransformStepper(): void
    {
        $stepperWithAvailableSizeModel = self::createStub(StepperWithAvailableSizeInterface::class);
        $stepperWithAvailableSizeTransformer = self::createStub(StepperWithAvailableSizeTransformerInterface::class);
        $stepperWithAvailableSizeTransformer->method('transform')->willReturn($stepperWithAvailableSizeModel);
        $listWithAvailableSizeModel = self::createStub(ListWithAvailableSizeInterface::class);
        $listWithAvailableSizeTransformer = self::createStub(ListWithAvailableSizeTransformerInterface::class);
        $listWithAvailableSizeTransformer->method('transform')->willReturn($listWithAvailableSizeModel);
        $pushButtonWithAvailableSizeModel = self::createStub(PushButtonWithAvailableSizeInterface::class);
        $pushButtonWithAvailableSizeTransformer = self::createStub(PushButtonWithAvailableSizeTransformerInterface::class);
        $pushButtonWithAvailableSizeTransformer->method('transform')->willReturn($pushButtonWithAvailableSizeModel);
        $stateWithAvailableSizeModel = self::createStub(StateWithAvailableSizeInterface::class);
        $stateWithAvailableSizeTransformer = self::createStub(StateWithAvailableSizeTransformerInterface::class);
        $stateWithAvailableSizeTransformer->method('transform')->willReturn($stateWithAvailableSizeModel);
        $sliderWithAvailableSizeModel = self::createStub(SliderWithAvailableSizeInterface::class);
        $sliderWithAvailableSizeTransformer = self::createStub(SliderWithAvailableSizeTransformerInterface::class);
        $sliderWithAvailableSizeTransformer->method('transform')->willReturn($sliderWithAvailableSizeModel);
        $emptyWithAvailableSizeModel = self::createStub(EmptyWithAvailableSizeInterface::class);
        $emptyWithAvailableSizeTransformer = self::createStub(EmptyWithAvailableSizeTransformerInterface::class);
        $emptyWithAvailableSizeTransformer->method('transform')->willReturn($emptyWithAvailableSizeModel);
        $transformer = new PanelItemForCapabilityTransformer($stepperWithAvailableSizeTransformer, $listWithAvailableSizeTransformer, $pushButtonWithAvailableSizeTransformer, $stateWithAvailableSizeTransformer, $sliderWithAvailableSizeTransformer, $emptyWithAvailableSizeTransformer);
        $base = [PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getStepper());
        self::assertNull($transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_STEPPER => 'test-not-array'])->getStepper());
        self::assertSame($stepperWithAvailableSizeModel, $transformer->transform($base + [PanelItemForCapabilityTransformerInterface::KEY_STEPPER => ['test-nested']])->getStepper());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PanelItemForCapabilityTransformer(self::createStub(StepperWithAvailableSizeTransformerInterface::class), self::createStub(ListWithAvailableSizeTransformerInterface::class), self::createStub(PushButtonWithAvailableSizeTransformerInterface::class), self::createStub(StateWithAvailableSizeTransformerInterface::class), self::createStub(SliderWithAvailableSizeTransformerInterface::class), self::createStub(EmptyWithAvailableSizeTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'displayTypeAbsent' => [[], sprintf(PanelItemForCapabilityTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE)];
        yield 'displayTypeWrongType' => [[PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE => 42], sprintf(PanelItemForCapabilityTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelItemForCapabilityTransformerInterface::KEY_DISPLAY_TYPE)];
    }
}
