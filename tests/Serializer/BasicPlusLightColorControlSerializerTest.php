<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControl;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColorInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlColorSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusLightColorControl::class)]
#[CoversClass(BasicPlusLightColorControlSerializer::class)]
final class BasicPlusLightColorControlSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusLightColorControlColorModel = self::createStub(BasicPlusLightColorControlColorInterface::class);
        $basicPlusLightColorControlColorSerializer = self::createStub(BasicPlusLightColorControlColorSerializerInterface::class);
        $basicPlusLightColorControlColorSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-light-color-control-color']);
        $model = new BasicPlusLightColorControl('test-component', 'test-capability', 'test-command', $basicPlusLightColorControlColorModel);

        $serializer = new BasicPlusLightColorControlSerializer($basicPlusLightColorControlColorSerializer);

        self::assertSame(
            [
                BasicPlusLightColorControlSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusLightColorControlSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusLightColorControlSerializerInterface::KEY_COMMAND => 'test-command',
                BasicPlusLightColorControlSerializerInterface::KEY_COLOR => ['test-serialized-basic-plus-light-color-control-color'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusLightColorControlColorModel = self::createStub(BasicPlusLightColorControlColorInterface::class);
        $basicPlusLightColorControlColorSerializer = self::createStub(BasicPlusLightColorControlColorSerializerInterface::class);
        $basicPlusLightColorControlColorSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-light-color-control-color']);
        $model = (new BasicPlusLightColorControl('test-component', 'test-capability', 'test-command', $basicPlusLightColorControlColorModel))
            ->setVersion(7)
            ->setValue('test-value');

        $serializer = new BasicPlusLightColorControlSerializer($basicPlusLightColorControlColorSerializer);

        self::assertSame(
            [
                BasicPlusLightColorControlSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusLightColorControlSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusLightColorControlSerializerInterface::KEY_VERSION => 7,
                BasicPlusLightColorControlSerializerInterface::KEY_COMMAND => 'test-command',
                BasicPlusLightColorControlSerializerInterface::KEY_VALUE => 'test-value',
                BasicPlusLightColorControlSerializerInterface::KEY_COLOR => ['test-serialized-basic-plus-light-color-control-color'],
            ],
            $serializer->serialize($model)
        );
    }
}
