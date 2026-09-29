<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommand;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;

use function is_string;

final class BasicPlusTvVolumeCommandTransformer implements BasicPlusTvVolumeCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvVolumeCommandInterface
    {
        $model = new BasicPlusTvVolumeCommand();

        self::applyName($model, $data);
        self::applyIncrease($model, $data);
        self::applyDecrease($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDecrease(BasicPlusTvVolumeCommand $model, array $data): void
    {
        if (empty($data[self::KEY_DECREASE])) {
            return;
        }
        if (!is_string($data[self::KEY_DECREASE])) {
            return;
        }
        $model->setDecrease($data[self::KEY_DECREASE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIncrease(BasicPlusTvVolumeCommand $model, array $data): void
    {
        if (empty($data[self::KEY_INCREASE])) {
            return;
        }
        if (!is_string($data[self::KEY_INCREASE])) {
            return;
        }
        $model->setIncrease($data[self::KEY_INCREASE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(BasicPlusTvVolumeCommand $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }
}
