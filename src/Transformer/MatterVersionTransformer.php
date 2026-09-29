<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterVersion;
use ChristianBrown\SmartThings\Model\MatterVersionInterface;

use function is_int;
use function is_numeric;
use function is_string;

final class MatterVersionTransformer implements MatterVersionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterVersionInterface
    {
        $model = new MatterVersion();

        self::applyHardware($model, $data);
        self::applyHardwareLabel($model, $data);
        self::applySoftware($model, $data);
        self::applySoftwareLabel($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHardware(MatterVersion $model, array $data): void
    {
        if (!isset($data[self::KEY_HARDWARE])) {
            return;
        }
        if (!is_int($data[self::KEY_HARDWARE])) {
            return;
        }
        $model->setHardware($data[self::KEY_HARDWARE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHardwareLabel(MatterVersion $model, array $data): void
    {
        if (empty($data[self::KEY_HARDWARE_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_HARDWARE_LABEL])) {
            return;
        }
        $model->setHardwareLabel($data[self::KEY_HARDWARE_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySoftware(MatterVersion $model, array $data): void
    {
        if (!isset($data[self::KEY_SOFTWARE])) {
            return;
        }
        if (!is_numeric($data[self::KEY_SOFTWARE])) {
            return;
        }
        $model->setSoftware((float) $data[self::KEY_SOFTWARE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySoftwareLabel(MatterVersion $model, array $data): void
    {
        if (empty($data[self::KEY_SOFTWARE_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_SOFTWARE_LABEL])) {
            return;
        }
        $model->setSoftwareLabel($data[self::KEY_SOFTWARE_LABEL]);
    }
}
