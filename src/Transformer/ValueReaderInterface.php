<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

interface ValueReaderInterface
{
    /**
     * The value under the key when it is a bool, otherwise null.
     *
     * @param array<array-key, mixed> $data
     */
    public function bool(array $data, string $key): ?bool;

    /**
     * The value under the key when it is an int, otherwise null.
     *
     * @param array<array-key, mixed> $data
     */
    public function int(array $data, string $key): ?int;

    /**
     * The value under the key when it is an array, otherwise null.
     *
     * @param array<array-key, mixed> $data
     *
     * @return null|array<array-key, mixed>
     */
    public function record(array $data, string $key): ?array;

    /**
     * The array entries of the list under the key; anything else in it is skipped.
     *
     * @param array<array-key, mixed> $data
     *
     * @return array<int, array<array-key, mixed>>
     */
    public function records(array $data, string $key): array;

    /**
     * The value under the key when it is a string, otherwise null.
     *
     * @param array<array-key, mixed> $data
     */
    public function string(array $data, string $key): ?string;
}
