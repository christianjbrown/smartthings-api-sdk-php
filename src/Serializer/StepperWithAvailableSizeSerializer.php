<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeStateInterface;

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
            self::KEY_COMMAND => $this->serializeOptionalStepperWithAvailableSizeCommand($model->getCommand()),
            self::KEY_STEP => $model->getStep(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
            self::KEY_STATE => $this->serializeOptionalStepperWithAvailableSizeState($model->getState()),
            self::KEY_AVAILABLE_SIZES => $model->getAvailableSizes(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalStepperWithAvailableSizeCommand(?StepperWithAvailableSizeCommandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->stepperWithAvailableSizeCommandSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalStepperWithAvailableSizeState(?StepperWithAvailableSizeStateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->stepperWithAvailableSizeStateSerializer->serialize($value);
    }
}
