<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\RuleRequestInterface;

use function array_filter;

final class RuleRequestSerializer implements RuleRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(RuleRequestInterface $request): array
    {
        $serialized = [
            self::KEY_NAME => $request->getName(),
            self::KEY_ACTIONS => $request->getActions(),
            self::KEY_SEQUENCE => $request->getSequence(),
            self::KEY_TIME_ZONE_ID => $request->getTimeZoneId(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
