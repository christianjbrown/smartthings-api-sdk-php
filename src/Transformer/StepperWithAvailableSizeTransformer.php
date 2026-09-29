<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSize;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeStateInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_numeric;
use function is_string;
use function sprintf;

final class StepperWithAvailableSizeTransformer implements StepperWithAvailableSizeTransformerInterface
{
    private StepperWithAvailableSizeCommandTransformerInterface $stepperWithAvailableSizeCommandTransformer;
    private StepperWithAvailableSizeStateTransformerInterface $stepperWithAvailableSizeStateTransformer;

    public function __construct(StepperWithAvailableSizeCommandTransformerInterface $stepperWithAvailableSizeCommandTransformer, StepperWithAvailableSizeStateTransformerInterface $stepperWithAvailableSizeStateTransformer)
    {
        $this->stepperWithAvailableSizeCommandTransformer = $stepperWithAvailableSizeCommandTransformer;
        $this->stepperWithAvailableSizeStateTransformer = $stepperWithAvailableSizeStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StepperWithAvailableSizeInterface
    {
        $model = new StepperWithAvailableSize($this->requireCommand($data), self::requireStep($data), self::requireRange($data), $this->requireState($data));

        self::applySupportedValues($model, $data);
        self::applyAvailableSizes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAvailableSizes(StepperWithAvailableSize $model, array $data): void
    {
        if (!isset($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        if (!is_array($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        $model->setAvailableSizes(array_values(array_filter($data[self::KEY_AVAILABLE_SIZES], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedValues(StepperWithAvailableSize $model, array $data): void
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
    private function requireState(array $data): StepperWithAvailableSizeStateInterface
    {
        if (!isset($data[self::KEY_STATE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_STATE));
        }
        if (!is_array($data[self::KEY_STATE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_STATE));
        }

        return $this->stepperWithAvailableSizeStateTransformer->transform($data[self::KEY_STATE]);
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
