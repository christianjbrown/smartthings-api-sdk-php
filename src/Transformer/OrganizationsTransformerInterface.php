<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\OrganizationInterface;

interface OrganizationsTransformerInterface
{
    public const string ARRAY_NAME = 'organization';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrganizationInterface>
     */
    public function transform(array $data): array;
}
