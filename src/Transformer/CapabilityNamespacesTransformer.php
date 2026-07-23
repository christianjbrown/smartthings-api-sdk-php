<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityNamespaceInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class CapabilityNamespacesTransformer implements CapabilityNamespacesTransformerInterface
{
    private CapabilityNamespaceTransformerInterface $capabilityNamespaceTransformer;

    public function __construct(CapabilityNamespaceTransformerInterface $capabilityNamespaceTransformer)
    {
        $this->capabilityNamespaceTransformer = $capabilityNamespaceTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityNamespaceInterface>
     */
    public function transform(array $data): array
    {
        $namespaces = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $namespaceData = $values[$i];
            if (!is_array($namespaceData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $namespaces[] = $this->capabilityNamespaceTransformer->transform($namespaceData);
        }

        return $namespaces;
    }
}
