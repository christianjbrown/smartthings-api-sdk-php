<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StateItem;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StateItemSerializer;
use ChristianBrown\SmartThings\Serializer\StateItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StateItem::class)]
#[CoversClass(StateItemSerializer::class)]
final class StateItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new StateItem('test-label');

        $serializer = new StateItemSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StateItemSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new StateItem('test-label'))
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new StateItemSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StateItemSerializerInterface::KEY_LABEL => 'test-label',
                StateItemSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
