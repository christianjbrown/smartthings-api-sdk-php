<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateSignatureTypeRequestInterface;

use function array_filter;

final class UpdateSignatureTypeRequestSerializer implements UpdateSignatureTypeRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(UpdateSignatureTypeRequestInterface $request): array
    {
        return self::filter([
            self::KEY_SIGNATURE_TYPE => $request->getSignatureType(),
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
