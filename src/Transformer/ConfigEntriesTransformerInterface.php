<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ConfigEntryInterface;

interface ConfigEntriesTransformerInterface
{
    /**
     * @param mixed[] $data A configuration map: each name holds a list of entries
     *
     * @return array<array-key, array<int, ConfigEntryInterface>>
     */
    public function transform(array $data): array;
}
