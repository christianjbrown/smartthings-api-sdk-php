<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForArgument;
use ChristianBrown\SmartThings\Serializer\TextFieldForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForArgumentSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextFieldForArgument::class)]
#[CoversClass(TextFieldForArgumentSerializer::class)]
final class TextFieldForArgumentSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new TextFieldForArgument('test-name');

        $serializer = new TextFieldForArgumentSerializer();

        self::assertSame(
            [
                TextFieldForArgumentSerializerInterface::KEY_NAME => 'test-name',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new TextFieldForArgument('test-name'))
            ->setArgumentType('test-argument-type')
            ->setRange(['test-range-key' => 'test-value']);

        $serializer = new TextFieldForArgumentSerializer();

        self::assertSame(
            [
                TextFieldForArgumentSerializerInterface::KEY_NAME => 'test-name',
                TextFieldForArgumentSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                TextFieldForArgumentSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
