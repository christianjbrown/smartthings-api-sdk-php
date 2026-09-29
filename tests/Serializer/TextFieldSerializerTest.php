<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\TextField;
use ChristianBrown\SmartThings\Serializer\TextFieldSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextField::class)]
#[CoversClass(TextFieldSerializer::class)]
final class TextFieldSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new TextField('test-command');

        $serializer = new TextFieldSerializer();

        self::assertSame(
            [
                TextFieldSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new TextField('test-command'))
            ->setArgumentType('test-argument-type')
            ->setValue('test-value')
            ->setValueType('test-value-type')
            ->setRange(['test-range-key' => 'test-value']);

        $serializer = new TextFieldSerializer();

        self::assertSame(
            [
                TextFieldSerializerInterface::KEY_COMMAND => 'test-command',
                TextFieldSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                TextFieldSerializerInterface::KEY_VALUE => 'test-value',
                TextFieldSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                TextFieldSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
