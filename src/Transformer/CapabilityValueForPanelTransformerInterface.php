<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueForPanelInterface;

interface CapabilityValueForPanelTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_ENABLED_VALUES = 'enabledValues';
    public const string KEY_KEY = 'key';
    public const string KEY_LABEL = 'label';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityValueForPanelInterface;
}
