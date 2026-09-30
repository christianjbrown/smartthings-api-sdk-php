<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ConfigEntryInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class ConfigEntriesTransformer implements ConfigEntriesTransformerInterface
{
    private ConfigEntryTransformerInterface $configEntryTransformer;

    public function __construct(ConfigEntryTransformerInterface $configEntryTransformer)
    {
        $this->configEntryTransformer = $configEntryTransformer;
    }

    /**
     * @param mixed[] $data A configuration map: each name holds a list of entries
     *
     * @return array<array-key, array<int, ConfigEntryInterface>>
     */
    public function transform(array $data): array
    {
        return array_map(
            fn (array $entries): array => array_values(array_map(fn (array $entry): ConfigEntryInterface => $this->configEntryTransformer->transform($entry), array_filter($entries, is_array(...)))),
            array_filter($data, is_array(...))
        );
    }
}
