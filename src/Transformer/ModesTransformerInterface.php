<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ModeInterface;

interface ModesTransformerInterface
{
    public const string ARRAY_NAME = 'mode';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ModeInterface>
     */
    public function transform(array $data): array;
}
