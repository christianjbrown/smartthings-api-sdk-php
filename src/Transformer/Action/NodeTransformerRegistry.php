<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Exception\UnregisteredTypeException;

use function sprintf;

final class NodeTransformerRegistry implements NodeTransformerRegistryInterface
{
    /**
     * @var array<class-string, NodeTransformerInterface<object>>
     */
    private array $transformers;

    /**
     * @param array<class-string, NodeTransformerInterface<object>> $transformers keyed by the model interface each one builds
     */
    public function __construct(array $transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @param class-string<T> $type the model interface to build
     *
     * @return NodeTransformerInterface<T>
     *
     * @template T of object
     */
    public function get(string $type): NodeTransformerInterface
    {
        if (!isset($this->transformers[$type])) {
            throw new UnregisteredTypeException(sprintf(self::UNREGISTERED_TYPE_SPRINTF, $type));
        }

        /**
         * @var NodeTransformerInterface<T> $transformer
         */
        $transformer = $this->transformers[$type];

        return $transformer;
    }
}
