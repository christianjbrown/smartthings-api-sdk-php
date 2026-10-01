<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\ArrayOperandInterface;
use ChristianBrown\SmartThings\Model\DateOperandInterface;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\DeviceOperandInterface;
use ChristianBrown\SmartThings\Model\LocationOperandInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;

use function array_filter;
use function array_map;

/**
 * Serializes OperandInterface into its JSON body.
 */
final class OperandNodeSerializer implements OperandNodeSerializerInterface
{
    /**
     * @param OperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_BOOLEAN => $value->getBoolean(),
            self::KEY_DECIMAL => $value->getDecimal(),
            self::KEY_INTEGER => $value->getInteger(),
            self::KEY_STRING => $value->getString(),
            self::KEY_ARRAY => self::serializeOptionalArrayOperand($value->getArray(), $registry),
            self::KEY_MAP => self::serializeOperandMap($value->getMap(), $registry),
            self::KEY_DEVICE => self::serializeOptionalDeviceOperand($value->getDevice(), $registry),
            self::KEY_LOCATION => self::serializeOptionalLocationOperand($value->getLocation(), $registry),
            self::KEY_DATE => self::serializeOptionalDateOperand($value->getDate(), $registry),
            self::KEY_TIME => self::serializeOptionalTimeOperand($value->getTime(), $registry),
            self::KEY_DATETIME => self::serializeOptionalDateTimeOperand($value->getDatetime(), $registry),
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
     * @param null|array<array-key, OperandInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeOperandMap(?array $values, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (OperandInterface $item): array => $registry->get(OperandInterface::class)->serialize($item, $registry), $values);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalArrayOperand(?ArrayOperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(ArrayOperandInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDateOperand(?DateOperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(DateOperandInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDateTimeOperand(?DateTimeOperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(DateTimeOperandInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDeviceOperand(?DeviceOperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(DeviceOperandInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLocationOperand(?LocationOperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(LocationOperandInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalTimeOperand(?TimeOperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(TimeOperandInterface::class)->serialize($value, $registry);
    }
}
