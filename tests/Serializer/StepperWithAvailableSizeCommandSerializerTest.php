<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommand;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperWithAvailableSizeCommand::class)]
#[CoversClass(StepperWithAvailableSizeCommandSerializer::class)]
final class StepperWithAvailableSizeCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new StepperWithAvailableSizeCommand();

        $serializer = new StepperWithAvailableSizeCommandSerializer();

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new StepperWithAvailableSizeCommand())
            ->setName('test-name')
            ->setIncrease('test-increase')
            ->setDecrease('test-decrease')
            ->setArgumentType('test-argument-type');

        $serializer = new StepperWithAvailableSizeCommandSerializer();

        self::assertSame(
            [
                StepperWithAvailableSizeCommandSerializerInterface::KEY_NAME => 'test-name',
                StepperWithAvailableSizeCommandSerializerInterface::KEY_INCREASE => 'test-increase',
                StepperWithAvailableSizeCommandSerializerInterface::KEY_DECREASE => 'test-decrease',
                StepperWithAvailableSizeCommandSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
