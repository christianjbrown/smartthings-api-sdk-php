<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;

use function array_filter;

final class PreferenceRequestSerializer implements PreferenceRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PreferenceRequestInterface $request): array
    {
        $serialized = [
            self::KEY_PREFERENCE_ID => $request->getPreferenceId(),
            self::KEY_NAME => $request->getName(),
            self::KEY_TITLE => $request->getTitle(),
            self::KEY_DESCRIPTION => $request->getDescription(),
            self::KEY_EXPLICIT => $request->getExplicit(),
            self::KEY_REQUIRED => $request->getRequired(),
            self::KEY_PREFERENCE_TYPE => $request->getPreferenceType(),
            self::KEY_DEFINITION => $request->getDefinition(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
