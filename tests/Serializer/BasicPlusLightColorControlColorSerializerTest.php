<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColor;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlColorSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlColorSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusLightColorControlColor::class)]
#[CoversClass(BasicPlusLightColorControlColorSerializer::class)]
final class BasicPlusLightColorControlColorSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new BasicPlusLightColorControlColor();

        $serializer = new BasicPlusLightColorControlColorSerializer();

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new BasicPlusLightColorControlColor())
            ->setHue('test-hue')
            ->setSaturation('test-saturation');

        $serializer = new BasicPlusLightColorControlColorSerializer();

        self::assertSame(
            [
                BasicPlusLightColorControlColorSerializerInterface::KEY_HUE => 'test-hue',
                BasicPlusLightColorControlColorSerializerInterface::KEY_SATURATION => 'test-saturation',
            ],
            $serializer->serialize($model)
        );
    }
}
