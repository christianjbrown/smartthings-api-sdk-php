<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppInterface;

interface AppsTransformerInterface
{
    public const string ARRAY_NAME = 'app';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, AppInterface>
     */
    public function transform(array $data): array;
}
