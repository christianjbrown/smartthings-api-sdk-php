<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\NumberField;
use ChristianBrown\SmartThings\Serializer\NumberFieldSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NumberField::class)]
#[CoversClass(NumberFieldSerializer::class)]
final class NumberFieldSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new NumberField('test-command');

        $serializer = new NumberFieldSerializer();

        self::assertSame(
            [
                NumberFieldSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new NumberField('test-command'))
            ->setValue('test-value')
            ->setValueType('test-value-type')
            ->setUnit('test-unit')
            ->setArgumentType('test-argument-type')
            ->setRange(['test-range-key' => 'test-value'])
            ->setSupportedValues('test-supported-values');

        $serializer = new NumberFieldSerializer();

        self::assertSame(
            [
                NumberFieldSerializerInterface::KEY_VALUE => 'test-value',
                NumberFieldSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                NumberFieldSerializerInterface::KEY_UNIT => 'test-unit',
                NumberFieldSerializerInterface::KEY_COMMAND => 'test-command',
                NumberFieldSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                NumberFieldSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                NumberFieldSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ],
            $serializer->serialize($model)
        );
    }
}
