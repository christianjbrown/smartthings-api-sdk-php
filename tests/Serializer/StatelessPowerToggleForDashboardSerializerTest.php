<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboard;
use ChristianBrown\SmartThings\Serializer\StatelessPowerToggleForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\StatelessPowerToggleForDashboardSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StatelessPowerToggleForDashboard::class)]
#[CoversClass(StatelessPowerToggleForDashboardSerializer::class)]
final class StatelessPowerToggleForDashboardSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new StatelessPowerToggleForDashboard('test-command');

        $serializer = new StatelessPowerToggleForDashboardSerializer();

        self::assertSame(
            [
                StatelessPowerToggleForDashboardSerializerInterface::KEY_COMMAND => 'test-command',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new StatelessPowerToggleForDashboard('test-command'))
            ->setArgument('test-argument')
            ->setArgumentType('test-argument-type');

        $serializer = new StatelessPowerToggleForDashboardSerializer();

        self::assertSame(
            [
                StatelessPowerToggleForDashboardSerializerInterface::KEY_COMMAND => 'test-command',
                StatelessPowerToggleForDashboardSerializerInterface::KEY_ARGUMENT => 'test-argument',
                StatelessPowerToggleForDashboardSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
