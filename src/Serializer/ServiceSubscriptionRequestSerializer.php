<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ServiceSubscriptionRequestInterface;

use function array_filter;

final class ServiceSubscriptionRequestSerializer implements ServiceSubscriptionRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ServiceSubscriptionRequestInterface $request): array
    {
        return self::filter([
            self::KEY_CAPABILITIES => $request->getCapabilities(),
            self::KEY_ISA_ID => $request->getIsaId(),
            self::KEY_POSTAL_CODE => $request->getPostalCode(),
            self::KEY_TYPE => $request->getType(),
            self::KEY_PREDICATE => $request->getPredicate(),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
