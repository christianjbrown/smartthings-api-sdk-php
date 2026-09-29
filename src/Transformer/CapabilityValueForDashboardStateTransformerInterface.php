<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardStateInterface;

interface CapabilityValueForDashboardStateTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_LABEL = 'label';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityValueForDashboardStateInterface;
}
