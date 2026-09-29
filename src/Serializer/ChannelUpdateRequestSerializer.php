<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ChannelUpdateRequestInterface;

use function array_filter;

final class ChannelUpdateRequestSerializer implements ChannelUpdateRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ChannelUpdateRequestInterface $request): array
    {
        return self::filter([
            self::KEY_NAME => $request->getName(),
            self::KEY_DESCRIPTION => $request->getDescription(),
            self::KEY_TERMS_OF_SERVICE_URL => $request->getTermsOfServiceUrl(),
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
