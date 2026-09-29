<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSize;
use ChristianBrown\SmartThings\Serializer\PushButtonWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\PushButtonWithAvailableSizeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PushButtonWithAvailableSize::class)]
#[CoversClass(PushButtonWithAvailableSizeSerializer::class)]
final class PushButtonWithAvailableSizeSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new PushButtonWithAvailableSize('test-command');

        $serializer = new PushButtonWithAvailableSizeSerializer();

        self::assertSame(
            [
                PushButtonWithAvailableSizeSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new PushButtonWithAvailableSize('test-command'))
            ->setArgument('test-argument')
            ->setArgumentType('test-argument-type')
            ->setIconUrl('test-icon-url')
            ->setAvailableSizes(['test-available-sizes-1', 'test-available-sizes-2']);

        $serializer = new PushButtonWithAvailableSizeSerializer();

        self::assertSame(
            [
                PushButtonWithAvailableSizeSerializerInterface::KEY_COMMAND => 'test-command',
                PushButtonWithAvailableSizeSerializerInterface::KEY_ARGUMENT => 'test-argument',
                PushButtonWithAvailableSizeSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                PushButtonWithAvailableSizeSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                PushButtonWithAvailableSizeSerializerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
            ],
            $serializer->serialize($model)
        );
    }
}
