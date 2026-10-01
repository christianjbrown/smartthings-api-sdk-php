<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;

interface ActionTransformerInterface extends ActionTreeKeysInterface
{
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_INT_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionInterface;

    /**
     * @param mixed[] $data
     */
    public function transformActionSequence(array $data): ActionSequenceInterface;

    /**
     * Transforms a list of Action objects, skipping entries that are not arrays.
     *
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    public function transformAll(array $data): array;

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionSequenceInterface>
     */
    public function transformAllActionSequence(array $data): array;

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionInterface>
     */
    public function transformMap(array $data): array;

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionSequenceInterface>
     */
    public function transformMapActionSequence(array $data): array;
}
