<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\ArrayOperandInterface;
use ChristianBrown\SmartThings\Model\DateOperandInterface;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\DeviceOperandInterface;
use ChristianBrown\SmartThings\Model\LocationOperandInterface;
use ChristianBrown\SmartThings\Model\Operand;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;

use function array_filter;
use function array_map;
use function is_array;
use function is_bool;
use function is_int;
use function is_numeric;
use function is_string;

/**
 * Builds OperandInterface from its decoded JSON.
 */
final class OperandNodeTransformer implements OperandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): OperandInterface
    {
        $model = new Operand();

        self::applyBoolean($model, $data);
        self::applyDecimal($model, $data);
        self::applyInteger($model, $data);
        self::applyString($model, $data);
        self::applyArray($model, $data, $registry);
        self::applyMap($model, $data, $registry);
        self::applyDevice($model, $data, $registry);
        self::applyLocation($model, $data, $registry);
        self::applyDate($model, $data, $registry);
        self::applyTime($model, $data, $registry);
        self::applyDatetime($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArray(Operand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_ARRAY])) {
            return;
        }
        if (!is_array($data[self::KEY_ARRAY])) {
            return;
        }
        $model->setArray($registry->get(ArrayOperandInterface::class)->transform($data[self::KEY_ARRAY], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBoolean(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_BOOLEAN])) {
            return;
        }
        if (!is_bool($data[self::KEY_BOOLEAN])) {
            return;
        }
        $model->setBoolean($data[self::KEY_BOOLEAN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDate(Operand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_DATE])) {
            return;
        }
        if (!is_array($data[self::KEY_DATE])) {
            return;
        }
        $model->setDate($registry->get(DateOperandInterface::class)->transform($data[self::KEY_DATE], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDatetime(Operand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_DATETIME])) {
            return;
        }
        if (!is_array($data[self::KEY_DATETIME])) {
            return;
        }
        $model->setDatetime($registry->get(DateTimeOperandInterface::class)->transform($data[self::KEY_DATETIME], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDecimal(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_DECIMAL])) {
            return;
        }
        if (!is_numeric($data[self::KEY_DECIMAL])) {
            return;
        }
        $model->setDecimal((float) $data[self::KEY_DECIMAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDevice(Operand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_DEVICE])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE])) {
            return;
        }
        $model->setDevice($registry->get(DeviceOperandInterface::class)->transform($data[self::KEY_DEVICE], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInteger(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_INTEGER])) {
            return;
        }
        if (!is_int($data[self::KEY_INTEGER])) {
            return;
        }
        $model->setInteger($data[self::KEY_INTEGER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocation(Operand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCATION])) {
            return;
        }
        $model->setLocation($registry->get(LocationOperandInterface::class)->transform($data[self::KEY_LOCATION], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMap(Operand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_MAP])) {
            return;
        }
        if (!is_array($data[self::KEY_MAP])) {
            return;
        }
        $model->setMap(self::toOperandMap($data[self::KEY_MAP], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyString(Operand $model, array $data): void
    {
        if (empty($data[self::KEY_STRING])) {
            return;
        }
        if (!is_string($data[self::KEY_STRING])) {
            return;
        }
        $model->setString($data[self::KEY_STRING]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTime(Operand $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_TIME])) {
            return;
        }
        if (!is_array($data[self::KEY_TIME])) {
            return;
        }
        $model->setTime($registry->get(TimeOperandInterface::class)->transform($data[self::KEY_TIME], $registry));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, OperandInterface>
     */
    private static function toOperandMap(array $data, NodeTransformerRegistryInterface $registry): array
    {
        $transformer = $registry->get(OperandInterface::class);

        return array_map(static fn (array $item): OperandInterface => $transformer->transform($item, $registry), array_filter($data, is_array(...)));
    }
}
