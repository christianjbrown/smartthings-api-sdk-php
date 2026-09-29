<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\NumberFieldForArgument;
use ChristianBrown\SmartThings\Serializer\NumberFieldForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForArgumentSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NumberFieldForArgument::class)]
#[CoversClass(NumberFieldForArgumentSerializer::class)]
final class NumberFieldForArgumentSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new NumberFieldForArgument('test-name');

        $serializer = new NumberFieldForArgumentSerializer();

        self::assertSame(
            [
                NumberFieldForArgumentSerializerInterface::KEY_NAME => 'test-name',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new NumberFieldForArgument('test-name'))
            ->setUnit('test-unit')
            ->setArgumentType('test-argument-type')
            ->setRange(['test-range-key' => 'test-value'])
            ->setSupportedValues('test-supported-values');

        $serializer = new NumberFieldForArgumentSerializer();

        self::assertSame(
            [
                NumberFieldForArgumentSerializerInterface::KEY_NAME => 'test-name',
                NumberFieldForArgumentSerializerInterface::KEY_UNIT => 'test-unit',
                NumberFieldForArgumentSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                NumberFieldForArgumentSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                NumberFieldForArgumentSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ],
            $serializer->serialize($model)
        );
    }
}
