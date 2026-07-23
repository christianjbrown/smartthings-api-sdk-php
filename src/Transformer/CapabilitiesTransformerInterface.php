<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityInterface;

interface CapabilitiesTransformerInterface
{
    public const string ARRAY_NAME = 'capability';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityInterface>
     */
    public function transform(array $data): array;
}
