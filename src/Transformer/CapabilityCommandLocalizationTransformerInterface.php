<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityCommandLocalizationInterface;

interface CapabilityCommandLocalizationTransformerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_LABEL = 'label';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityCommandLocalizationInterface;
}
