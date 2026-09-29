<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationAction;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationActionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextFieldForAutomationAction::class)]
#[CoversClass(TextFieldForAutomationActionSerializer::class)]
final class TextFieldForAutomationActionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new TextFieldForAutomationAction('test-command');

        $serializer = new TextFieldForAutomationActionSerializer();

        self::assertSame(
            [
                TextFieldForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new TextFieldForAutomationAction('test-command'))
            ->setArgumentType('test-argument-type')
            ->setRange(['test-range-key' => 'test-value']);

        $serializer = new TextFieldForAutomationActionSerializer();

        self::assertSame(
            [
                TextFieldForAutomationActionSerializerInterface::KEY_COMMAND => 'test-command',
                TextFieldForAutomationActionSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                TextFieldForAutomationActionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
