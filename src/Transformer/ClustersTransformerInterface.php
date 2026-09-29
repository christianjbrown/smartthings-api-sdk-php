<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ClustersInterface;

interface ClustersTransformerInterface
{
    public const string KEY_CLIENT = 'client';
    public const string KEY_SERVER = 'server';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ClustersInterface;
}
