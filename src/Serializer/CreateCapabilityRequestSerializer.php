<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AttributeDataSchemaInterface;
use ChristianBrown\SmartThings\Model\AttributePropertiesInterface;
use ChristianBrown\SmartThings\Model\AttributeSchemaInterface;
use ChristianBrown\SmartThings\Model\AttributeUnitSchemaInterface;
use ChristianBrown\SmartThings\Model\AttributeValueSchemaInterface;
use ChristianBrown\SmartThings\Model\CapabilityAttributeInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandInterface;
use ChristianBrown\SmartThings\Model\CommandArgumentInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityRequestInterface;
use ChristianBrown\SmartThings\Model\EnumCommandInterface;

use function array_filter;
use function array_map;

final class CreateCapabilityRequestSerializer implements CreateCapabilityRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CreateCapabilityRequestInterface $request): array
    {
        return self::filter([
            self::KEY_NAME => $request->getName(),
            self::KEY_EPHEMERAL => $request->getEphemeral(),
            self::KEY_ATTRIBUTES => self::serializeCapabilityAttributeMap($request->getAttributes()),
            self::KEY_COMMANDS => self::serializeCapabilityCommandMap($request->getCommands()),
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
    private static function serializeAttributeDataSchema(AttributeDataSchemaInterface $value): array
    {
        return self::filter([
            self::KEY_TYPE => $value->getType(),
            self::KEY_ADDITIONAL_PROPERTIES => $value->getAdditionalProperties(),
            self::KEY_REQUIRED => $value->getRequired(),
            self::KEY_PROPERTIES => $value->getProperties(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeAttributeProperties(AttributePropertiesInterface $value): array
    {
        return self::filter([
            self::KEY_VALUE => self::serializeOptionalAttributeValueSchema($value->getValue()),
            self::KEY_UNIT => self::serializeOptionalAttributeUnitSchema($value->getUnit()),
            self::KEY_DATA => self::serializeOptionalAttributeDataSchema($value->getData()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeAttributeSchema(AttributeSchemaInterface $value): array
    {
        return self::filter([
            self::KEY_TITLE => $value->getTitle(),
            self::KEY_TYPE => $value->getType(),
            self::KEY_PROPERTIES => self::serializeOptionalAttributeProperties($value->getProperties()),
            self::KEY_SENSITIVE => $value->getSensitive(),
            self::KEY_ADDITIONAL_PROPERTIES => $value->getAdditionalProperties(),
            self::KEY_REQUIRED => $value->getRequired(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeAttributeUnitSchema(AttributeUnitSchemaInterface $value): array
    {
        return self::filter([
            self::KEY_TYPE => $value->getType(),
            self::KEY_ENUM => $value->getEnum(),
            self::KEY_DEFAULT => $value->getDefault(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeAttributeValueSchema(AttributeValueSchemaInterface $value): array
    {
        return self::filter([
            self::KEY_TYPE => $value->getType(),
            self::KEY_ENUM => $value->getEnum(),
        ] + ($value->getAdditionalKeywords() ?? []));
    }

    /**
     * @return mixed[]
     */
    private static function serializeCapabilityAttribute(CapabilityAttributeInterface $value): array
    {
        return self::filter([
            self::KEY_SCHEMA => self::serializeOptionalAttributeSchema($value->getSchema()),
            self::KEY_SETTER => $value->getSetter(),
            self::KEY_ENUM_COMMANDS => self::serializeEnumCommandList($value->getEnumCommands()),
        ]);
    }

    /**
     * @param null|array<array-key, CapabilityAttributeInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeCapabilityAttributeMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (CapabilityAttributeInterface $item): array => self::serializeCapabilityAttribute($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCapabilityCommand(CapabilityCommandInterface $value): array
    {
        return self::filter([
            self::KEY_NAME => $value->getName(),
            self::KEY_ARGUMENTS => self::serializeCommandArgumentList($value->getArguments()),
            self::KEY_SENSITIVE => $value->getSensitive(),
        ]);
    }

    /**
     * @param null|array<array-key, CapabilityCommandInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeCapabilityCommandMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (CapabilityCommandInterface $item): array => self::serializeCapabilityCommand($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCommandArgument(CommandArgumentInterface $value): array
    {
        return self::filter([
            self::KEY_NAME => $value->getName(),
            self::KEY_OPTIONAL => $value->getOptional(),
            self::KEY_SCHEMA => $value->getSchema(),
        ]);
    }

    /**
     * @param null|array<int, CommandArgumentInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeCommandArgumentList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (CommandArgumentInterface $item): array => self::serializeCommandArgument($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeEnumCommand(EnumCommandInterface $value): array
    {
        return self::filter([
            self::KEY_COMMAND => $value->getCommand(),
            self::KEY_VALUE => $value->getValue(),
        ]);
    }

    /**
     * @param null|array<int, EnumCommandInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeEnumCommandList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (EnumCommandInterface $item): array => self::serializeEnumCommand($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalAttributeDataSchema(?AttributeDataSchemaInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeAttributeDataSchema($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalAttributeProperties(?AttributePropertiesInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeAttributeProperties($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalAttributeSchema(?AttributeSchemaInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeAttributeSchema($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalAttributeUnitSchema(?AttributeUnitSchemaInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeAttributeUnitSchema($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalAttributeValueSchema(?AttributeValueSchemaInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeAttributeValueSchema($value);
    }
}
