<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SceneInterface;

interface ScenesTransformerInterface
{
    public const string ARRAY_NAME = 'scene';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneInterface>
     */
    public function transform(array $data): array;
}
