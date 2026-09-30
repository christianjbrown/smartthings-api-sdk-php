<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSize;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeStateInterface;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperWithAvailableSize::class)]
#[CoversClass(StepperWithAvailableSizeSerializer::class)]
final class StepperWithAvailableSizeSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $stepperWithAvailableSizeCommandSerializer = self::createStub(StepperWithAvailableSizeCommandSerializerInterface::class);
        $stepperWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-command']);
        $stepperWithAvailableSizeStateSerializer = self::createStub(StepperWithAvailableSizeStateSerializerInterface::class);
        $stepperWithAvailableSizeStateSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-state']);
        $model = new StepperWithAvailableSize(null, 1.5, ['test-range-key' => 'test-value'], null);

        $serializer = new StepperWithAvailableSizeSerializer($stepperWithAvailableSizeCommandSerializer, $stepperWithAvailableSizeStateSerializer);

        self::assertSame(
            [
                StepperWithAvailableSizeSerializerInterface::KEY_STEP => 1.5,
                StepperWithAvailableSizeSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeRequiredFieldsOnly(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandSerializer = self::createStub(StepperWithAvailableSizeCommandSerializerInterface::class);
        $stepperWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-command']);
        $stepperWithAvailableSizeStateModel = self::createStub(StepperWithAvailableSizeStateInterface::class);
        $stepperWithAvailableSizeStateSerializer = self::createStub(StepperWithAvailableSizeStateSerializerInterface::class);
        $stepperWithAvailableSizeStateSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-state']);
        $model = new StepperWithAvailableSize($stepperWithAvailableSizeCommandModel, 1.5, ['test-range-key' => 'test-value'], $stepperWithAvailableSizeStateModel);

        $serializer = new StepperWithAvailableSizeSerializer($stepperWithAvailableSizeCommandSerializer, $stepperWithAvailableSizeStateSerializer);

        self::assertSame(
            [
                StepperWithAvailableSizeSerializerInterface::KEY_COMMAND => ['test-serialized-stepper-with-available-size-command'],
                StepperWithAvailableSizeSerializerInterface::KEY_STEP => 1.5,
                StepperWithAvailableSizeSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                StepperWithAvailableSizeSerializerInterface::KEY_STATE => ['test-serialized-stepper-with-available-size-state'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandSerializer = self::createStub(StepperWithAvailableSizeCommandSerializerInterface::class);
        $stepperWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-command']);
        $stepperWithAvailableSizeStateModel = self::createStub(StepperWithAvailableSizeStateInterface::class);
        $stepperWithAvailableSizeStateSerializer = self::createStub(StepperWithAvailableSizeStateSerializerInterface::class);
        $stepperWithAvailableSizeStateSerializer->method('serialize')->willReturn(['test-serialized-stepper-with-available-size-state']);
        $model = (new StepperWithAvailableSize($stepperWithAvailableSizeCommandModel, 1.5, ['test-range-key' => 'test-value'], $stepperWithAvailableSizeStateModel))
            ->setSupportedValues('test-supported-values')
            ->setAvailableSizes(['test-available-sizes-1', 'test-available-sizes-2']);

        $serializer = new StepperWithAvailableSizeSerializer($stepperWithAvailableSizeCommandSerializer, $stepperWithAvailableSizeStateSerializer);

        self::assertSame(
            [
                StepperWithAvailableSizeSerializerInterface::KEY_COMMAND => ['test-serialized-stepper-with-available-size-command'],
                StepperWithAvailableSizeSerializerInterface::KEY_STEP => 1.5,
                StepperWithAvailableSizeSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                StepperWithAvailableSizeSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                StepperWithAvailableSizeSerializerInterface::KEY_STATE => ['test-serialized-stepper-with-available-size-state'],
                StepperWithAvailableSizeSerializerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
            ],
            $serializer->serialize($model)
        );
    }
}
