<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItem;
use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusLightInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemActionsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemProgressBarsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusItem::class)]
#[CoversClass(BasicPlusItemSerializer::class)]
final class BasicPlusItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraSerializer = self::createStub(BasicPlusCameraSerializerInterface::class);
        $basicPlusCameraSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera']);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvSerializer = self::createStub(BasicPlusTvSerializerInterface::class);
        $basicPlusTvSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv']);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightSerializer = self::createStub(BasicPlusLightSerializerInterface::class);
        $basicPlusLightSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-light']);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemSerializer = self::createStub(BasicPlusItemActionsItemSerializerInterface::class);
        $basicPlusItemActionsItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-item-actions-item']);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemSerializer = self::createStub(BasicPlusStateBoardItemSerializerInterface::class);
        $basicPlusStateBoardItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-state-board-item']);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemSerializer = self::createStub(BasicPlusItemProgressBarsItemSerializerInterface::class);
        $basicPlusItemProgressBarsItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-item-progress-bars-item']);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigSerializer = self::createStub(PanelForDeviceConfigSerializerInterface::class);
        $panelForDeviceConfigSerializer->method('serialize')->willReturn(['test-serialized-panel-for-device-config']);
        $model = new BasicPlusItem('test-display-type');

        $serializer = new BasicPlusItemSerializer($basicPlusCameraSerializer, $basicPlusTvSerializer, $basicPlusLightSerializer, $basicPlusItemActionsItemSerializer, $basicPlusStateBoardItemSerializer, $basicPlusItemProgressBarsItemSerializer, $panelForDeviceConfigSerializer);

        self::assertSame(
            [
                BasicPlusItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusCameraModel = self::createStub(BasicPlusCameraInterface::class);
        $basicPlusCameraSerializer = self::createStub(BasicPlusCameraSerializerInterface::class);
        $basicPlusCameraSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera']);
        $basicPlusTvModel = self::createStub(BasicPlusTvInterface::class);
        $basicPlusTvSerializer = self::createStub(BasicPlusTvSerializerInterface::class);
        $basicPlusTvSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv']);
        $basicPlusLightModel = self::createStub(BasicPlusLightInterface::class);
        $basicPlusLightSerializer = self::createStub(BasicPlusLightSerializerInterface::class);
        $basicPlusLightSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-light']);
        $basicPlusItemActionsItemModel = self::createStub(BasicPlusItemActionsItemInterface::class);
        $basicPlusItemActionsItemSerializer = self::createStub(BasicPlusItemActionsItemSerializerInterface::class);
        $basicPlusItemActionsItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-item-actions-item']);
        $basicPlusStateBoardItemModel = self::createStub(BasicPlusStateBoardItemInterface::class);
        $basicPlusStateBoardItemSerializer = self::createStub(BasicPlusStateBoardItemSerializerInterface::class);
        $basicPlusStateBoardItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-state-board-item']);
        $basicPlusItemProgressBarsItemModel = self::createStub(BasicPlusItemProgressBarsItemInterface::class);
        $basicPlusItemProgressBarsItemSerializer = self::createStub(BasicPlusItemProgressBarsItemSerializerInterface::class);
        $basicPlusItemProgressBarsItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-item-progress-bars-item']);
        $panelForDeviceConfigModel = self::createStub(PanelForDeviceConfigInterface::class);
        $panelForDeviceConfigSerializer = self::createStub(PanelForDeviceConfigSerializerInterface::class);
        $panelForDeviceConfigSerializer->method('serialize')->willReturn(['test-serialized-panel-for-device-config']);
        $model = (new BasicPlusItem('test-display-type'))
            ->setCamera($basicPlusCameraModel)
            ->setTv($basicPlusTvModel)
            ->setLight($basicPlusLightModel)
            ->setActions([$basicPlusItemActionsItemModel])
            ->setStateBoard([$basicPlusStateBoardItemModel])
            ->setProgressBars([$basicPlusItemProgressBarsItemModel])
            ->setPanel($panelForDeviceConfigModel);

        $serializer = new BasicPlusItemSerializer($basicPlusCameraSerializer, $basicPlusTvSerializer, $basicPlusLightSerializer, $basicPlusItemActionsItemSerializer, $basicPlusStateBoardItemSerializer, $basicPlusItemProgressBarsItemSerializer, $panelForDeviceConfigSerializer);

        self::assertSame(
            [
                BasicPlusItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
                BasicPlusItemSerializerInterface::KEY_CAMERA => ['test-serialized-basic-plus-camera'],
                BasicPlusItemSerializerInterface::KEY_TV => ['test-serialized-basic-plus-tv'],
                BasicPlusItemSerializerInterface::KEY_LIGHT => ['test-serialized-basic-plus-light'],
                BasicPlusItemSerializerInterface::KEY_ACTIONS => [['test-serialized-basic-plus-item-actions-item']],
                BasicPlusItemSerializerInterface::KEY_STATE_BOARD => [['test-serialized-basic-plus-state-board-item']],
                BasicPlusItemSerializerInterface::KEY_PROGRESS_BARS => [['test-serialized-basic-plus-item-progress-bars-item']],
                BasicPlusItemSerializerInterface::KEY_PANEL => ['test-serialized-panel-for-device-config'],
            ],
            $serializer->serialize($model)
        );
    }
}
