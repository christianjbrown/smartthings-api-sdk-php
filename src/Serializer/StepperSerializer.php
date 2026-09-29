<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StepperInterface;

use function array_filter;

final class StepperSerializer implements StepperSerializerInterface
{
    private StepperWithAvailableSizeCommandSerializerInterface $stepperWithAvailableSizeCommandSerializer;

    public function __construct(StepperWithAvailableSizeCommandSerializerInterface $stepperWithAvailableSizeCommandSerializer)
    {
        $this->stepperWithAvailableSizeCommandSerializer = $stepperWithAvailableSizeCommandSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(StepperInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $this->stepperWithAvailableSizeCommandSerializer->serialize($model->getCommand()),
            self::KEY_STEP => $model->getStep(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
