<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\Stepper;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Serializer\StepperSerializer;
use ChristianBrown\SmartThings\Serializer\StepperSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Stepper::class)]
#[CoversClass(StepperSerializer::class)]
final class StepperSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandSerializer = self::createStub(StepperWithAvailableSizeCommandSerializerInterface::class);
        $stepperWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-command']);
        $model = new Stepper($stepperWithAvailableSizeCommandModel, 1.5, ['test-range-key' => 'test-value']);

        $serializer = new StepperSerializer($stepperWithAvailableSizeCommandSerializer);

        self::assertSame(
            [
                StepperSerializerInterface::KEY_COMMAND => ['test-serialized-stepper-with-available-size-command'],
                StepperSerializerInterface::KEY_STEP => 1.5,
                StepperSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandSerializer = self::createStub(StepperWithAvailableSizeCommandSerializerInterface::class);
        $stepperWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-command']);
        $model = (new Stepper($stepperWithAvailableSizeCommandModel, 1.5, ['test-range-key' => 'test-value']))
            ->setSupportedValues('test-supported-values')
            ->setValue('test-value')
            ->setValueType('test-value-type');

        $serializer = new StepperSerializer($stepperWithAvailableSizeCommandSerializer);

        self::assertSame(
            [
                StepperSerializerInterface::KEY_COMMAND => ['test-serialized-stepper-with-available-size-command'],
                StepperSerializerInterface::KEY_STEP => 1.5,
                StepperSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                StepperSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                StepperSerializerInterface::KEY_VALUE => 'test-value',
                StepperSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ],
            $serializer->serialize($model)
        );
    }
}
