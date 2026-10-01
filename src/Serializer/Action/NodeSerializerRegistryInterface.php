<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Exception\UnregisteredTypeExceptionInterface;

interface NodeSerializerRegistryInterface
{
    public const string UNREGISTERED_TYPE_SPRINTF = 'No action tree serializer is registered for %s';

    /**
     * @param class-string<T> $type the model interface to build
     *
     * @throws UnregisteredTypeExceptionInterface
     *
     * @return NodeSerializerInterface<T>
     *
     * @template T of object
     */
    public function get(string $type): NodeSerializerInterface;
}
