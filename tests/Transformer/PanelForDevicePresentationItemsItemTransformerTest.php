<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EmptyForPanelItemInterface;
use ChristianBrown\SmartThings\Model\ListForPanelItemInterface;
use ChristianBrown\SmartThings\Model\PanelForDevicePresentationItemsItem;
use ChristianBrown\SmartThings\Model\PushButtonForPanelItemInterface;
use ChristianBrown\SmartThings\Model\SliderForPanelItemInterface;
use ChristianBrown\SmartThings\Model\StateForPanelItemInterface;
use ChristianBrown\SmartThings\Model\StepperForPanelItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\EmptyForPanelItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationItemsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationItemsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PushButtonForPanelItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForPanelItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StateForPanelItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PanelForDevicePresentationItemsItem::class)]
#[CoversClass(PanelForDevicePresentationItemsItemTransformer::class)]
final class PanelForDevicePresentationItemsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_VERSION => 7,
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component',
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_LABEL => 'test-label',
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_STEPPER => ['test-nested'],
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_LIST => ['test-nested'],
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested'],
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_STATE => ['test-nested'],
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_SLIDER => ['test-nested'],
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_EMPTY => ['test-nested'],
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
            PanelForDevicePresentationItemsItemTransformerInterface::KEY_HIDE_ON_UNMATCH => true,
        ];

        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($stepperForPanelItemModel, $actual->getStepper());
        self::assertSame($listForPanelItemModel, $actual->getList());
        self::assertSame($pushButtonForPanelItemModel, $actual->getPushButton());
        self::assertSame($stateForPanelItemModel, $actual->getState());
        self::assertSame($sliderForPanelItemModel, $actual->getSlider());
        self::assertSame($emptyForPanelItemModel, $actual->getEmpty());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
        self::assertTrue($actual->getHideOnUnmatch());
    }

    public function testTransformEmpty(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getEmpty());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_EMPTY => 'test-not-array'])->getEmpty());
        self::assertSame($emptyForPanelItemModel, $transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_EMPTY => ['test-nested']])->getEmpty());
    }

    public function testTransformList(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listForPanelItemModel, $transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_LIST => ['test-nested']])->getList());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PanelForDevicePresentationItemsItemTransformer(self::createStub(StepperForPanelItemTransformerInterface::class), self::createStub(ListForPanelItemTransformerInterface::class), self::createStub(PushButtonForPanelItemTransformerInterface::class), self::createStub(StateForPanelItemTransformerInterface::class), self::createStub(SliderForPanelItemTransformerInterface::class), self::createStub(EmptyForPanelItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
        yield 'hideOnUnmatchAbsent' => [[], 'getHideOnUnmatch', null];
        yield 'hideOnUnmatchWrongType' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_HIDE_ON_UNMATCH => 'not-bool'], 'getHideOnUnmatch', null];
        yield 'hideOnUnmatchValid' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_HIDE_ON_UNMATCH => true], 'getHideOnUnmatch', true];
    }

    public function testTransformPushButton(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPushButton());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_PUSH_BUTTON => 'test-not-array'])->getPushButton());
        self::assertSame($pushButtonForPanelItemModel, $transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested']])->getPushButton());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getStepper());
        self::assertNull($actual->getList());
        self::assertNull($actual->getPushButton());
        self::assertNull($actual->getState());
        self::assertNull($actual->getSlider());
        self::assertNull($actual->getEmpty());
        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
        self::assertNull($actual->getHideOnUnmatch());
    }

    public function testTransformSlider(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderForPanelItemModel, $transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
    }

    public function testTransformState(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($stateForPanelItemModel, $transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }

    public function testTransformStepper(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getStepper());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_STEPPER => 'test-not-array'])->getStepper());
        self::assertSame($stepperForPanelItemModel, $transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_STEPPER => ['test-nested']])->getStepper());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PanelForDevicePresentationItemsItemTransformer(self::createStub(StepperForPanelItemTransformerInterface::class), self::createStub(ListForPanelItemTransformerInterface::class), self::createStub(PushButtonForPanelItemTransformerInterface::class), self::createStub(StateForPanelItemTransformerInterface::class), self::createStub(SliderForPanelItemTransformerInterface::class), self::createStub(EmptyForPanelItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], sprintf(PanelForDevicePresentationItemsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 42], sprintf(PanelForDevicePresentationItemsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY)];
        yield 'componentAbsent' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], sprintf(PanelForDevicePresentationItemsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 42], sprintf(PanelForDevicePresentationItemsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT)];
        yield 'displayTypeAbsent' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(PanelForDevicePresentationItemsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE)];
        yield 'displayTypeWrongType' => [[PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 42], sprintf(PanelForDevicePresentationItemsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE)];
    }

    public function testTransformVisibleConditions(): void
    {
        $stepperForPanelItemModel = self::createStub(StepperForPanelItemInterface::class);
        $stepperForPanelItemTransformer = self::createStub(StepperForPanelItemTransformerInterface::class);
        $stepperForPanelItemTransformer->method('transform')->willReturn($stepperForPanelItemModel);
        $listForPanelItemModel = self::createStub(ListForPanelItemInterface::class);
        $listForPanelItemTransformer = self::createStub(ListForPanelItemTransformerInterface::class);
        $listForPanelItemTransformer->method('transform')->willReturn($listForPanelItemModel);
        $pushButtonForPanelItemModel = self::createStub(PushButtonForPanelItemInterface::class);
        $pushButtonForPanelItemTransformer = self::createStub(PushButtonForPanelItemTransformerInterface::class);
        $pushButtonForPanelItemTransformer->method('transform')->willReturn($pushButtonForPanelItemModel);
        $stateForPanelItemModel = self::createStub(StateForPanelItemInterface::class);
        $stateForPanelItemTransformer = self::createStub(StateForPanelItemTransformerInterface::class);
        $stateForPanelItemTransformer->method('transform')->willReturn($stateForPanelItemModel);
        $sliderForPanelItemModel = self::createStub(SliderForPanelItemInterface::class);
        $sliderForPanelItemTransformer = self::createStub(SliderForPanelItemTransformerInterface::class);
        $sliderForPanelItemTransformer->method('transform')->willReturn($sliderForPanelItemModel);
        $emptyForPanelItemModel = self::createStub(EmptyForPanelItemInterface::class);
        $emptyForPanelItemTransformer = self::createStub(EmptyForPanelItemTransformerInterface::class);
        $emptyForPanelItemTransformer->method('transform')->willReturn($emptyForPanelItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationItemsItemTransformer($stepperForPanelItemTransformer, $listForPanelItemTransformer, $pushButtonForPanelItemTransformer, $stateForPanelItemTransformer, $sliderForPanelItemTransformer, $emptyForPanelItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationItemsItemTransformerInterface::KEY_CAPABILITY => 'test-capability', PanelForDevicePresentationItemsItemTransformerInterface::KEY_COMPONENT => 'test-component', PanelForDevicePresentationItemsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [PanelForDevicePresentationItemsItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
