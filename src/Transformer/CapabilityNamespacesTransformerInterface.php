<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityNamespaceInterface;

interface CapabilityNamespacesTransformerInterface
{
    public const string ARRAY_NAME = 'namespace';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityNamespaceInterface>
     */
    public function transform(array $data): array;
}
