<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemActionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemActionsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusItemActionsItem::class)]
#[CoversClass(BasicPlusItemActionsItemSerializer::class)]
final class BasicPlusItemActionsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new BasicPlusItemActionsItem('test-command', 'test-component', 'test-capability');

        $serializer = new BasicPlusItemActionsItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusItemActionsItemSerializerInterface::KEY_COMMAND => 'test-command',
                BasicPlusItemActionsItemSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusItemActionsItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new BasicPlusItemActionsItem('test-command', 'test-component', 'test-capability'))
            ->setArgument('test-argument')
            ->setArgumentType('test-argument-type')
            ->setIconUrl('test-icon-url')
            ->setVersion(7)
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionModel]);

        $serializer = new BasicPlusItemActionsItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusItemActionsItemSerializerInterface::KEY_COMMAND => 'test-command',
                BasicPlusItemActionsItemSerializerInterface::KEY_ARGUMENT => 'test-argument',
                BasicPlusItemActionsItemSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                BasicPlusItemActionsItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                BasicPlusItemActionsItemSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusItemActionsItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusItemActionsItemSerializerInterface::KEY_VERSION => 7,
                BasicPlusItemActionsItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                BasicPlusItemActionsItemSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
            ],
            $serializer->serialize($model)
        );
    }
}
