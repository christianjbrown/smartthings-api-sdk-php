<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeInterface;

interface StepperWithAvailableSizeSerializerInterface
{
    public const string KEY_AVAILABLE_SIZES = 'availableSizes';
    public const string KEY_COMMAND = 'command';
    public const string KEY_RANGE = 'range';
    public const string KEY_STATE = 'state';
    public const string KEY_STEP = 'step';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';

    /**
     * @return mixed[]
     */
    public function serialize(StepperWithAvailableSizeInterface $model): array;
}
