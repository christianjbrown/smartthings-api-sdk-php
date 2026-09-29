<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeInterface;

use function array_filter;

final class StepperWithAvailableSizeSerializer implements StepperWithAvailableSizeSerializerInterface
{
    private StepperWithAvailableSizeCommandSerializerInterface $stepperWithAvailableSizeCommandSerializer;
    private StepperWithAvailableSizeStateSerializerInterface $stepperWithAvailableSizeStateSerializer;

    public function __construct(StepperWithAvailableSizeCommandSerializerInterface $stepperWithAvailableSizeCommandSerializer, StepperWithAvailableSizeStateSerializerInterface $stepperWithAvailableSizeStateSerializer)
    {
        $this->stepperWithAvailableSizeCommandSerializer = $stepperWithAvailableSizeCommandSerializer;
        $this->stepperWithAvailableSizeStateSerializer = $stepperWithAvailableSizeStateSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(StepperWithAvailableSizeInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $this->stepperWithAvailableSizeCommandSerializer->serialize($model->getCommand()),
            self::KEY_STEP => $model->getStep(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
            self::KEY_STATE => $this->stepperWithAvailableSizeStateSerializer->serialize($model->getState()),
            self::KEY_AVAILABLE_SIZES => $model->getAvailableSizes(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
