<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusCameraInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItem;
use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusLightInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemActionsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemProgressBarsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BasicPlusItem::class)]
#[CoversClass(BasicPlusItemTransformer::class)]
final class BasicPlusItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $data = [
            BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            BasicPlusItemTransformerInterface::KEY_CAMERA => ['test-nested'],
            BasicPlusItemTransformerInterface::KEY_TV => ['test-nested'],
            BasicPlusItemTransformerInterface::KEY_LIGHT => ['test-nested'],
            BasicPlusItemTransformerInterface::KEY_ACTIONS => [['test-nested']],
            BasicPlusItemTransformerInterface::KEY_STATE_BOARD => [['test-nested']],
            BasicPlusItemTransformerInterface::KEY_PROGRESS_BARS => [['test-nested']],
            BasicPlusItemTransformerInterface::KEY_PANEL => ['test-nested'],
        ];

        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($basicPlusCameraModel, $actual->getCamera());
        self::assertSame($basicPlusTvModel, $actual->getTv());
        self::assertSame($basicPlusLightModel, $actual->getLight());
        self::assertSame([$basicPlusItemActionsItemModel], $actual->getActions());
        self::assertSame([$basicPlusStateBoardItemModel], $actual->getStateBoard());
        self::assertSame([$basicPlusItemProgressBarsItemModel], $actual->getProgressBars());
        self::assertSame($panelForDeviceConfigModel, $actual->getPanel());
    }

    public function testTransformActions(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);
        $base = [BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$basicPlusItemActionsItemModel], $transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformCamera(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);
        $base = [BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getCamera());
        self::assertNull($transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_CAMERA => 'test-not-array'])->getCamera());
        self::assertSame($basicPlusCameraModel, $transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_CAMERA => ['test-nested']])->getCamera());
    }

    public function testTransformLight(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);
        $base = [BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getLight());
        self::assertNull($transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_LIGHT => 'test-not-array'])->getLight());
        self::assertSame($basicPlusLightModel, $transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_LIGHT => ['test-nested']])->getLight());
    }

    public function testTransformPanel(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);
        $base = [BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPanel());
        self::assertNull($transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_PANEL => 'test-not-array'])->getPanel());
        self::assertSame($panelForDeviceConfigModel, $transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_PANEL => ['test-nested']])->getPanel());
    }

    public function testTransformProgressBars(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);
        $base = [BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getProgressBars());
        self::assertNull($transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_PROGRESS_BARS => 'test-not-array'])->getProgressBars());
        self::assertSame([$basicPlusItemProgressBarsItemModel], $transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_PROGRESS_BARS => [['test-nested'], 'test-skipped']])->getProgressBars());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);

        $actual = $transformer->transform([BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getCamera());
        self::assertNull($actual->getTv());
        self::assertNull($actual->getLight());
        self::assertNull($actual->getActions());
        self::assertNull($actual->getStateBoard());
        self::assertNull($actual->getProgressBars());
        self::assertNull($actual->getPanel());
    }

    public function testTransformStateBoard(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);
        $base = [BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getStateBoard());
        self::assertNull($transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_STATE_BOARD => 'test-not-array'])->getStateBoard());
        self::assertSame([$basicPlusStateBoardItemModel], $transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_STATE_BOARD => [['test-nested'], 'test-skipped']])->getStateBoard());
    }

    public function testTransformTv(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraTransformer = self::createStub(BasicPlusCameraTransformerInterface::class);
        $basicPlusCameraTransformer->method('transform')->willReturn($basicPlusCameraModel);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvTransformer = self::createStub(BasicPlusTvTransformerInterface::class);
        $basicPlusTvTransformer->method('transform')->willReturn($basicPlusTvModel);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightTransformer = self::createStub(BasicPlusLightTransformerInterface::class);
        $basicPlusLightTransformer->method('transform')->willReturn($basicPlusLightModel);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemTransformer = self::createStub(BasicPlusItemActionsItemTransformerInterface::class);
        $basicPlusItemActionsItemTransformer->method('transform')->willReturn($basicPlusItemActionsItemModel);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemTransformer = self::createStub(BasicPlusStateBoardItemTransformerInterface::class);
        $basicPlusStateBoardItemTransformer->method('transform')->willReturn($basicPlusStateBoardItemModel);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemTransformer = self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class);
        $basicPlusItemProgressBarsItemTransformer->method('transform')->willReturn($basicPlusItemProgressBarsItemModel);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigTransformer = self::createStub(PanelForDeviceConfigTransformerInterface::class);
        $panelForDeviceConfigTransformer->method('transform')->willReturn($panelForDeviceConfigModel);
        $transformer = new BasicPlusItemTransformer($basicPlusCameraTransformer, $basicPlusTvTransformer, $basicPlusLightTransformer, $basicPlusItemActionsItemTransformer, $basicPlusStateBoardItemTransformer, $basicPlusItemProgressBarsItemTransformer, $panelForDeviceConfigTransformer);
        $base = [BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTv());
        self::assertNull($transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_TV => 'test-not-array'])->getTv());
        self::assertSame($basicPlusTvModel, $transformer->transform($base + [BasicPlusItemTransformerInterface::KEY_TV => ['test-nested']])->getTv());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new BasicPlusItemTransformer(self::createStub(BasicPlusCameraTransformerInterface::class), self::createStub(BasicPlusTvTransformerInterface::class), self::createStub(BasicPlusLightTransformerInterface::class), self::createStub(BasicPlusItemActionsItemTransformerInterface::class), self::createStub(BasicPlusStateBoardItemTransformerInterface::class), self::createStub(BasicPlusItemProgressBarsItemTransformerInterface::class), self::createStub(PanelForDeviceConfigTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'displayTypeAbsent' => [[], sprintf(BasicPlusItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE)];
        yield 'displayTypeWrongType' => [[BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE => 42], sprintf(BasicPlusItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusItemTransformerInterface::KEY_DISPLAY_TYPE)];
    }
}
