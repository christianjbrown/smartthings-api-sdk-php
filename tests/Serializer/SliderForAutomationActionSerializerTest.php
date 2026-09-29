<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationAction;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationActionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderForAutomationAction::class)]
#[CoversClass(SliderForAutomationActionSerializer::class)]
final class SliderForAutomationActionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new SliderForAutomationAction(['test-range-key' => 'test-value'], 'test-command');

        $serializer = new SliderForAutomationActionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderForAutomationActionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new SliderForAutomationAction(['test-range-key' => 'test-value'], 'test-command'))
            ->setStep(1.5)
            ->setUnit('test-unit')
            ->setSupportedValues('test-supported-values')
            ->setAlternatives([$alternativeItemModel])
            ->setArgumentType('test-argument-type');

        $serializer = new SliderForAutomationActionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderForAutomationActionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForAutomationActionSerializerInterface::KEY_STEP => 1.5,
                SliderForAutomationActionSerializerInterface::KEY_UNIT => 'test-unit',
                SliderForAutomationActionSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                SliderForAutomationActionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                SliderForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
                SliderForAutomationActionSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
