<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\StepperForPanelItemCommandInterface;

interface StepperForPanelItemCommandTransformerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_DECREASE = 'decrease';
    public const string KEY_INCREASE = 'increase';
    public const string KEY_NAME = 'name';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StepperForPanelItemCommandInterface;
}
