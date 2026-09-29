<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityDetailsInterface;

interface CapabilityDetailsTransformerInterface
{
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_COMMANDS = 'commands';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityDetailsInterface;
}
