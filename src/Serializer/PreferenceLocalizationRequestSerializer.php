<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceLocalizationRequestInterface;
use ChristianBrown\SmartThings\Model\PreferenceOptionLocalizationInterface;

use function array_filter;
use function array_map;

final class PreferenceLocalizationRequestSerializer implements PreferenceLocalizationRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PreferenceLocalizationRequestInterface $request): array
    {
        return self::filter([
            self::KEY_TAG => $request->getTag(),
            self::KEY_LABEL => $request->getLabel(),
            self::KEY_DESCRIPTION => $request->getDescription(),
            self::KEY_OPTIONS => self::serializePreferenceOptionLocalizationMap($request->getOptions()),
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

    /**
     * @return mixed[]
     */
    private static function serializePreferenceOptionLocalization(PreferenceOptionLocalizationInterface $value): array
    {
        return self::filter([
            self::KEY_LABEL => $value->getLabel(),
        ]);
    }

    /**
     * @param null|array<array-key, PreferenceOptionLocalizationInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializePreferenceOptionLocalizationMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (PreferenceOptionLocalizationInterface $item): array => self::serializePreferenceOptionLocalization($item), $values);
    }
}
