<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PushButton;
use ChristianBrown\SmartThings\Serializer\PushButtonSerializer;
use ChristianBrown\SmartThings\Serializer\PushButtonSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PushButton::class)]
#[CoversClass(PushButtonSerializer::class)]
final class PushButtonSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new PushButton('test-command');

        $serializer = new PushButtonSerializer();

        self::assertSame(
            [
                PushButtonSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new PushButton('test-command'))
            ->setArgument('test-argument')
            ->setArgumentType('test-argument-type');

        $serializer = new PushButtonSerializer();

        self::assertSame(
            [
                PushButtonSerializerInterface::KEY_COMMAND => 'test-command',
                PushButtonSerializerInterface::KEY_ARGUMENT => 'test-argument',
                PushButtonSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
