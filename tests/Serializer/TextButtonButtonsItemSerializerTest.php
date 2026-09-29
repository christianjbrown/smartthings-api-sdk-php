<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\TextButtonButtonsItem;
use ChristianBrown\SmartThings\Serializer\TextButtonButtonsItemSerializer;
use ChristianBrown\SmartThings\Serializer\TextButtonButtonsItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextButtonButtonsItem::class)]
#[CoversClass(TextButtonButtonsItemSerializer::class)]
final class TextButtonButtonsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new TextButtonButtonsItem('test-key', 'test-label');

        $serializer = new TextButtonButtonsItemSerializer();

        self::assertSame(
            [
                TextButtonButtonsItemSerializerInterface::KEY_KEY => 'test-key',
                TextButtonButtonsItemSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new TextButtonButtonsItem('test-key', 'test-label'))
            ->setState('test-state');

        $serializer = new TextButtonButtonsItemSerializer();

        self::assertSame(
            [
                TextButtonButtonsItemSerializerInterface::KEY_KEY => 'test-key',
                TextButtonButtonsItemSerializerInterface::KEY_LABEL => 'test-label',
                TextButtonButtonsItemSerializerInterface::KEY_STATE => 'test-state',
            ],
            $serializer->serialize($model)
        );
    }
}
