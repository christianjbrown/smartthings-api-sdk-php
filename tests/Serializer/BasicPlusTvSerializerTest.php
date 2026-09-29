<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTv;
use ChristianBrown\SmartThings\Model\BasicPlusTvChannelInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeInterface;
use ChristianBrown\SmartThings\Model\ButtonForTvInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvChannelSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ButtonForTvSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTv::class)]
#[CoversClass(BasicPlusTvSerializer::class)]
final class BasicPlusTvSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeSerializer = self::createStub(BasicPlusTvVolumeSerializerInterface::class);
        $basicPlusTvVolumeSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-volume']);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvSerializer = self::createStub(ButtonForTvSerializerInterface::class);
        $buttonForTvSerializer->method('serialize')->willReturn(['test-serialized-button-for-tv']);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelSerializer = self::createStub(BasicPlusTvChannelSerializerInterface::class);
        $basicPlusTvChannelSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-channel']);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadSerializer = self::createStub(BasicPlusTvDirectionalPadSerializerInterface::class);
        $basicPlusTvDirectionalPadSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-directional-pad']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new BasicPlusTv([$buttonForTvModel]);

        $serializer = new BasicPlusTvSerializer($basicPlusTvVolumeSerializer, $buttonForTvSerializer, $basicPlusTvChannelSerializer, $basicPlusTvDirectionalPadSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusTvSerializerInterface::KEY_BUTTONS => [['test-serialized-button-for-tv']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeSerializer = self::createStub(BasicPlusTvVolumeSerializerInterface::class);
        $basicPlusTvVolumeSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-volume']);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvSerializer = self::createStub(ButtonForTvSerializerInterface::class);
        $buttonForTvSerializer->method('serialize')->willReturn(['test-serialized-button-for-tv']);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelSerializer = self::createStub(BasicPlusTvChannelSerializerInterface::class);
        $basicPlusTvChannelSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-channel']);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadSerializer = self::createStub(BasicPlusTvDirectionalPadSerializerInterface::class);
        $basicPlusTvDirectionalPadSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-directional-pad']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new BasicPlusTv([$buttonForTvModel]))
            ->setVolume($basicPlusTvVolumeModel)
            ->setChannel($basicPlusTvChannelModel)
            ->setDirectionalPad($basicPlusTvDirectionalPadModel)
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionModel])
            ->setHideDashboardActions(true);

        $serializer = new BasicPlusTvSerializer($basicPlusTvVolumeSerializer, $buttonForTvSerializer, $basicPlusTvChannelSerializer, $basicPlusTvDirectionalPadSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusTvSerializerInterface::KEY_VOLUME => ['test-serialized-basic-plus-tv-volume'],
                BasicPlusTvSerializerInterface::KEY_BUTTONS => [['test-serialized-button-for-tv']],
                BasicPlusTvSerializerInterface::KEY_CHANNEL => ['test-serialized-basic-plus-tv-channel'],
                BasicPlusTvSerializerInterface::KEY_DIRECTIONAL_PAD => ['test-serialized-basic-plus-tv-directional-pad'],
                BasicPlusTvSerializerInterface::KEY_OPERATOR => 'test-operator',
                BasicPlusTvSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
                BasicPlusTvSerializerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true,
            ],
            $serializer->serialize($model)
        );
    }
}
