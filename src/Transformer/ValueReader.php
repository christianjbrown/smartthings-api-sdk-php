<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use function array_filter;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class ValueReader implements ValueReaderInterface
{
    /**
     * @param array<array-key, mixed> $data
     */
    public function bool(array $data, string $key): ?bool
    {
        $value = $data[$key] ?? null;

        return is_bool($value) ? $value : null;
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public function int(array $data, string $key): ?int
    {
        $value = $data[$key] ?? null;

        return is_int($value) ? $value : null;
    }

    /**
     * @param array<array-key, mixed> $data
     *
     * @return null|array<array-key, mixed>
     */
    public function record(array $data, string $key): ?array
    {
        $value = $data[$key] ?? null;

        return is_array($value) ? $value : null;
    }

    /**
     * @param array<array-key, mixed> $data
     *
     * @return array<int, array<array-key, mixed>>
     */
    public function records(array $data, string $key): array
    {
        return array_values(array_filter($this->record($data, $key) ?? [], is_array(...)));
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public function string(array $data, string $key): ?string
    {
        $value = $data[$key] ?? null;

        return is_string($value) ? $value : null;
    }
}
