<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLight;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlInterface;
use ChristianBrown\SmartThings\Model\SliderForLightInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderForLightSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusLight::class)]
#[CoversClass(BasicPlusLightSerializer::class)]
final class BasicPlusLightSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $sliderForLightModel = self::createStub(SliderForLightInterface::class);
        $sliderForLightSerializer = self::createStub(SliderForLightSerializerInterface::class);
        $sliderForLightSerializer->method('serialize')->willReturn(['test-serialized-slider-for-light']);
        $basicPlusLightColorControlModel = self::createStub(BasicPlusLightColorControlInterface::class);
        $basicPlusLightColorControlSerializer = self::createStub(BasicPlusLightColorControlSerializerInterface::class);
        $basicPlusLightColorControlSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-light-color-control']);
        $model = new BasicPlusLight($sliderForLightModel);

        $serializer = new BasicPlusLightSerializer($sliderForLightSerializer, $basicPlusLightColorControlSerializer);

        self::assertSame(
            [
                BasicPlusLightSerializerInterface::KEY_DIMMER => ['test-serialized-slider-for-light'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $sliderForLightModel = self::createStub(SliderForLightInterface::class);
        $sliderForLightSerializer = self::createStub(SliderForLightSerializerInterface::class);
        $sliderForLightSerializer->method('serialize')->willReturn(['test-serialized-slider-for-light']);
        $basicPlusLightColorControlModel = self::createStub(BasicPlusLightColorControlInterface::class);
        $basicPlusLightColorControlSerializer = self::createStub(BasicPlusLightColorControlSerializerInterface::class);
        $basicPlusLightColorControlSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-light-color-control']);
        $model = (new BasicPlusLight($sliderForLightModel))
            ->setColorTemperature($sliderForLightModel)
            ->setColorControl($basicPlusLightColorControlModel)
            ->setHideDashboardActions(true);

        $serializer = new BasicPlusLightSerializer($sliderForLightSerializer, $basicPlusLightColorControlSerializer);

        self::assertSame(
            [
                BasicPlusLightSerializerInterface::KEY_DIMMER => ['test-serialized-slider-for-light'],
                BasicPlusLightSerializerInterface::KEY_COLOR_TEMPERATURE => ['test-serialized-slider-for-light'],
                BasicPlusLightSerializerInterface::KEY_COLOR_CONTROL => ['test-serialized-basic-plus-light-color-control'],
                BasicPlusLightSerializerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true,
            ],
            $serializer->serialize($model)
        );
    }
}
