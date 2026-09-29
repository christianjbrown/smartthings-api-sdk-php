<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ButtonForTv;
use ChristianBrown\SmartThings\Serializer\ButtonForTvSerializer;
use ChristianBrown\SmartThings\Serializer\ButtonForTvSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ButtonForTv::class)]
#[CoversClass(ButtonForTvSerializer::class)]
final class ButtonForTvSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new ButtonForTv('test-capability', 'test-component', 'test-command');

        $serializer = new ButtonForTvSerializer();

        self::assertSame(
            [
                ButtonForTvSerializerInterface::KEY_CAPABILITY => 'test-capability',
                ButtonForTvSerializerInterface::KEY_COMPONENT => 'test-component',
                ButtonForTvSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new ButtonForTv('test-capability', 'test-component', 'test-command'))
            ->setVersion(7)
            ->setArgument('test-argument')
            ->setIconUrl('test-icon-url');

        $serializer = new ButtonForTvSerializer();

        self::assertSame(
            [
                ButtonForTvSerializerInterface::KEY_CAPABILITY => 'test-capability',
                ButtonForTvSerializerInterface::KEY_VERSION => 7,
                ButtonForTvSerializerInterface::KEY_COMPONENT => 'test-component',
                ButtonForTvSerializerInterface::KEY_COMMAND => 'test-command',
                ButtonForTvSerializerInterface::KEY_ARGUMENT => 'test-argument',
                ButtonForTvSerializerInterface::KEY_ICON_URL => 'test-icon-url',
            ],
            $serializer->serialize($model)
        );
    }
}
