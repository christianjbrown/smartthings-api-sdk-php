<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentI18nInterface;
use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLabelInterface;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityLocalizationRequestInterface;

use function array_filter;
use function array_map;

final class CapabilityLocalizationRequestSerializer implements CapabilityLocalizationRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CapabilityLocalizationRequestInterface $request): array
    {
        return self::filter([
            self::KEY_TAG => $request->getTag(),
            self::KEY_LABEL => $request->getLabel(),
            self::KEY_DESCRIPTION => $request->getDescription(),
            self::KEY_ATTRIBUTES => self::serializeCapabilityAttributeLocalizationMap($request->getAttributes()),
            self::KEY_COMMANDS => self::serializeCapabilityCommandLocalizationMap($request->getCommands()),
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
    private static function serializeCapabilityArgumentI18n(CapabilityArgumentI18nInterface $value): array
    {
        return self::filter([
            self::KEY_LABEL => $value->getLabel(),
        ]);
    }

    /**
     * @param null|array<array-key, CapabilityArgumentI18nInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeCapabilityArgumentI18nMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (CapabilityArgumentI18nInterface $item): array => self::serializeCapabilityArgumentI18n($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCapabilityArgumentLocalization(CapabilityArgumentLocalizationInterface $value): array
    {
        return self::filter([
            self::KEY_I18N => self::serializeCapabilityArgumentI18nMap($value->getI18n()),
            self::KEY_LABEL => $value->getLabel(),
            self::KEY_DESCRIPTION => $value->getDescription(),
        ]);
    }

    /**
     * @param null|array<array-key, CapabilityArgumentLocalizationInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeCapabilityArgumentLocalizationMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (CapabilityArgumentLocalizationInterface $item): array => self::serializeCapabilityArgumentLocalization($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCapabilityAttributeLabel(CapabilityAttributeLabelInterface $value): array
    {
        return self::filter([
            self::KEY_LABEL => $value->getLabel(),
            self::KEY_DESCRIPTION => $value->getDescription(),
        ]);
    }

    /**
     * @param null|array<array-key, array<array-key, CapabilityAttributeLabelInterface>> $values
     *
     * @return null|array<array-key, array<array-key, mixed[]>>
     */
    private static function serializeCapabilityAttributeLabelMapMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (array $inner): array => array_map(static fn (CapabilityAttributeLabelInterface $item): array => self::serializeCapabilityAttributeLabel($item), $inner), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCapabilityAttributeLocalization(CapabilityAttributeLocalizationInterface $value): array
    {
        return self::filter([
            self::KEY_LABEL => $value->getLabel(),
            self::KEY_DESCRIPTION => $value->getDescription(),
            self::KEY_DISPLAY_TEMPLATE => $value->getDisplayTemplate(),
            self::KEY_I18N => self::serializeCapabilityAttributeLabelMapMap($value->getI18n()),
        ]);
    }

    /**
     * @param null|array<array-key, CapabilityAttributeLocalizationInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeCapabilityAttributeLocalizationMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (CapabilityAttributeLocalizationInterface $item): array => self::serializeCapabilityAttributeLocalization($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCapabilityCommandLocalization(CapabilityCommandLocalizationInterface $value): array
    {
        return self::filter([
            self::KEY_LABEL => $value->getLabel(),
            self::KEY_DESCRIPTION => $value->getDescription(),
            self::KEY_ARGUMENTS => self::serializeCapabilityArgumentLocalizationMap($value->getArguments()),
        ]);
    }

    /**
     * @param null|array<array-key, CapabilityCommandLocalizationInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeCapabilityCommandLocalizationMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (CapabilityCommandLocalizationInterface $item): array => self::serializeCapabilityCommandLocalization($item), $values);
    }
}
