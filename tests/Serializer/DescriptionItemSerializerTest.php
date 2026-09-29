<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DescriptionItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\DescriptionItemSerializer;
use ChristianBrown\SmartThings\Serializer\DescriptionItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DescriptionItem::class)]
#[CoversClass(DescriptionItemSerializer::class)]
final class DescriptionItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new DescriptionItem('test-label');

        $serializer = new DescriptionItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                DescriptionItemSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new DescriptionItem('test-label'))
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionModel]);

        $serializer = new DescriptionItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                DescriptionItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                DescriptionItemSerializerInterface::KEY_LABEL => 'test-label',
                DescriptionItemSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
            ],
            $serializer->serialize($model)
        );
    }
}
