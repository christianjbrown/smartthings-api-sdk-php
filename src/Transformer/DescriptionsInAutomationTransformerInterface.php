<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;

interface DescriptionsInAutomationTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_CONDITIONS = 'conditions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DescriptionsInAutomationInterface;
}
