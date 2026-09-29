<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationAction;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationActionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NumberFieldForAutomationAction::class)]
#[CoversClass(NumberFieldForAutomationActionSerializer::class)]
final class NumberFieldForAutomationActionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new NumberFieldForAutomationAction('test-command');

        $serializer = new NumberFieldForAutomationActionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                NumberFieldForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new NumberFieldForAutomationAction('test-command'))
            ->setArgumentType('test-argument-type')
            ->setUnit('test-unit')
            ->setRange(['test-range-key' => 'test-value'])
            ->setAlternatives([$alternativeItemModel])
            ->setSupportedValues('test-supported-values')
            ->setDescription('test-description');

        $serializer = new NumberFieldForAutomationActionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                NumberFieldForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
                NumberFieldForAutomationActionSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                NumberFieldForAutomationActionSerializerInterface::KEY_UNIT => 'test-unit',
                NumberFieldForAutomationActionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                NumberFieldForAutomationActionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                NumberFieldForAutomationActionSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                NumberFieldForAutomationActionSerializerInterface::KEY_DESCRIPTION => 'test-description',
            ],
            $serializer->serialize($model)
        );
    }
}
