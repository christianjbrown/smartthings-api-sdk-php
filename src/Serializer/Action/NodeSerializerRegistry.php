<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Exception\UnregisteredTypeException;

use function sprintf;

final class NodeSerializerRegistry implements NodeSerializerRegistryInterface
{
    /**
     * @var array<class-string, NodeSerializerInterface<*>>
     */
    private array $transformers;

    /**
     * @param array<class-string, NodeSerializerInterface<*>> $transformers keyed by the model interface each one builds
     */
    public function __construct(array $transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @param class-string<T> $type the model interface to build
     *
     * @return NodeSerializerInterface<T>
     *
     * @template T of object
     */
    public function get(string $type): NodeSerializerInterface
    {
        if (!isset($this->transformers[$type])) {
            throw new UnregisteredTypeException(sprintf(self::UNREGISTERED_TYPE_SPRINTF, $type));
        }

        /**
         * @var NodeSerializerInterface<T> $transformer
         */
        $transformer = $this->transformers[$type];

        return $transformer;
    }
}
