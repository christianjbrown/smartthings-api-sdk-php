<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommand;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;

use function is_string;

final class StepperWithAvailableSizeCommandTransformer implements StepperWithAvailableSizeCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StepperWithAvailableSizeCommandInterface
    {
        $model = new StepperWithAvailableSizeCommand();

        self::applyName($model, $data);
        self::applyIncrease($model, $data);
        self::applyDecrease($model, $data);
        self::applyArgumentType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(StepperWithAvailableSizeCommand $model, array $data): void
    {
        if (empty($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        $model->setArgumentType($data[self::KEY_ARGUMENT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDecrease(StepperWithAvailableSizeCommand $model, array $data): void
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
    private static function applyIncrease(StepperWithAvailableSizeCommand $model, array $data): void
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
    private static function applyName(StepperWithAvailableSizeCommand $model, array $data): void
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
