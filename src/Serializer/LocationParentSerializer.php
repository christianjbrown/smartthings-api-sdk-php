<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\LocationParentInterface;

use function array_filter;

final class LocationParentSerializer implements LocationParentSerializerInterface
{
    /**
     * @return array<string, string>
     */
    public function serialize(LocationParentInterface $parent): array
    {
        return array_filter(
            [
                self::KEY_ID => $parent->getId(),
                self::KEY_TYPE => $parent->getType(),
            ],
            static fn (?string $value): bool => null !== $value
        );
    }
}
