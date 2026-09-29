<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommand;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ToggleSwitchForDashboardCommand::class)]
#[CoversClass(ToggleSwitchForDashboardCommandSerializer::class)]
final class ToggleSwitchForDashboardCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new ToggleSwitchForDashboardCommand('test-on', 'test-off');

        $serializer = new ToggleSwitchForDashboardCommandSerializer();

        self::assertSame(
            [
                ToggleSwitchForDashboardCommandSerializerInterface::KEY_ON => 'test-on',
                ToggleSwitchForDashboardCommandSerializerInterface::KEY_OFF => 'test-off',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new ToggleSwitchForDashboardCommand('test-on', 'test-off'))
            ->setName('test-name')
            ->setArgumentType('test-argument-type');

        $serializer = new ToggleSwitchForDashboardCommandSerializer();

        self::assertSame(
            [
                ToggleSwitchForDashboardCommandSerializerInterface::KEY_NAME => 'test-name',
                ToggleSwitchForDashboardCommandSerializerInterface::KEY_ON => 'test-on',
                ToggleSwitchForDashboardCommandSerializerInterface::KEY_OFF => 'test-off',
                ToggleSwitchForDashboardCommandSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
