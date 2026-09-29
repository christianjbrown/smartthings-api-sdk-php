<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\StepperForPanelItem;
use ChristianBrown\SmartThings\Model\StepperForPanelItemCommandInterface;
use ChristianBrown\SmartThings\Model\StepperForPanelItemInterface;
use ChristianBrown\SmartThings\Model\StepperForPanelItemStateInterface;

use function is_array;
use function is_numeric;
use function is_string;
use function sprintf;

final class StepperForPanelItemTransformer implements StepperForPanelItemTransformerInterface
{
    private StepperForPanelItemCommandTransformerInterface $stepperForPanelItemCommandTransformer;
    private StepperForPanelItemStateTransformerInterface $stepperForPanelItemStateTransformer;

    public function __construct(StepperForPanelItemCommandTransformerInterface $stepperForPanelItemCommandTransformer, StepperForPanelItemStateTransformerInterface $stepperForPanelItemStateTransformer)
    {
        $this->stepperForPanelItemCommandTransformer = $stepperForPanelItemCommandTransformer;
        $this->stepperForPanelItemStateTransformer = $stepperForPanelItemStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StepperForPanelItemInterface
    {
        $model = new StepperForPanelItem($this->requireCommand($data), self::requireStep($data), self::requireRange($data), $this->requireState($data), self::requireSize($data));

        self::applySupportedValues($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedValues(StepperForPanelItem $model, array $data): void
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
    private function requireCommand(array $data): StepperForPanelItemCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }

        return $this->stepperForPanelItemCommandTransformer->transform($data[self::KEY_COMMAND]);
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
    private static function requireSize(array $data): string
    {
        if (empty($data[self::KEY_SIZE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_SIZE));
        }
        if (!is_string($data[self::KEY_SIZE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_SIZE));
        }

        return $data[self::KEY_SIZE];
    }

    /**
     * @param mixed[] $data
     */
    private function requireState(array $data): StepperForPanelItemStateInterface
    {
        if (!isset($data[self::KEY_STATE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_STATE));
        }
        if (!is_array($data[self::KEY_STATE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_STATE));
        }

        return $this->stepperForPanelItemStateTransformer->transform($data[self::KEY_STATE]);
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
