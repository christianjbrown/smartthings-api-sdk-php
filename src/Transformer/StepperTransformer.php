<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Stepper;
use ChristianBrown\SmartThings\Model\StepperInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;

use function is_array;
use function is_numeric;
use function is_string;
use function sprintf;

final class StepperTransformer implements StepperTransformerInterface
{
    private StepperWithAvailableSizeCommandTransformerInterface $stepperWithAvailableSizeCommandTransformer;

    public function __construct(StepperWithAvailableSizeCommandTransformerInterface $stepperWithAvailableSizeCommandTransformer)
    {
        $this->stepperWithAvailableSizeCommandTransformer = $stepperWithAvailableSizeCommandTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StepperInterface
    {
        $model = new Stepper($this->requireCommand($data), self::requireStep($data), self::requireRange($data));

        self::applySupportedValues($model, $data);
        self::applyValue($model, $data);
        self::applyValueType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedValues(Stepper $model, array $data): void
    {
        if (empty($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        if (!is_string($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        $model->setSupportedValues($data[self::KEY_SUPPORTED_VALUES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(Stepper $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(Stepper $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        $model->setValueType($data[self::KEY_VALUE_TYPE]);
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): StepperWithAvailableSizeCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }

        return $this->stepperWithAvailableSizeCommandTransformer->transform($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    private static function requireRange(array $data): array
    {
        if (!isset($data[self::KEY_RANGE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_RANGE));
        }
        if (!is_array($data[self::KEY_RANGE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_RANGE));
        }

        return $data[self::KEY_RANGE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireStep(array $data): float
    {
        if (!isset($data[self::KEY_STEP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_NUMBER_SPRINTF, self::KEY_STEP));
        }
        if (!is_numeric($data[self::KEY_STEP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_NUMBER_SPRINTF, self::KEY_STEP));
        }

        return (float) $data[self::KEY_STEP];
    }
}
