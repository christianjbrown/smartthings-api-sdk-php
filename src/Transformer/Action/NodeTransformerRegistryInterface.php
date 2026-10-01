<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Exception\UnregisteredTypeExceptionInterface;

interface NodeTransformerRegistryInterface
{
    public const string UNREGISTERED_TYPE_SPRINTF = 'No action tree transformer is registered for %s';

    /**
     * @param class-string<T> $type the model interface to build
     *
     * @throws UnregisteredTypeExceptionInterface
     *
     * @return NodeTransformerInterface<T>
     *
     * @template T of object
     */
    public function get(string $type): NodeTransformerInterface;
}
