<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;

interface StepperWithAvailableSizeCommandSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_DECREASE = 'decrease';
    public const string KEY_INCREASE = 'increase';
    public const string KEY_NAME = 'name';

    /**
     * @return mixed[]
     */
    public function serialize(StepperWithAvailableSizeCommandInterface $model): array;
}
