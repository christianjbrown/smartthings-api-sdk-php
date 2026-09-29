<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolume;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeInterface;

use function is_array;
use function is_int;
use function is_numeric;
use function is_string;
use function sprintf;

final class BasicPlusTvVolumeTransformer implements BasicPlusTvVolumeTransformerInterface
{
    private BasicPlusTvVolumeCommandTransformerInterface $basicPlusTvVolumeCommandTransformer;

    public function __construct(BasicPlusTvVolumeCommandTransformerInterface $basicPlusTvVolumeCommandTransformer)
    {
        $this->basicPlusTvVolumeCommandTransformer = $basicPlusTvVolumeCommandTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvVolumeInterface
    {
        $model = new BasicPlusTvVolume(self::requireCapability($data), self::requireComponent($data), $this->requireCommand($data));

        self::applyVersion($model, $data);
        self::applyLabel($model, $data);
        self::applyValue($model, $data);
        self::applyStep($model, $data);
        self::applyRange($model, $data);
        self::applySupportedValues($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(BasicPlusTvVolume $model, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $model->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRange(BasicPlusTvVolume $model, array $data): void
    {
        if (!isset($data[self::KEY_RANGE])) {
            return;
        }
        if (!is_array($data[self::KEY_RANGE])) {
            return;
        }
        $model->setRange($data[self::KEY_RANGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStep(BasicPlusTvVolume $model, array $data): void
    {
        if (!isset($data[self::KEY_STEP])) {
            return;
        }
        if (!is_numeric($data[self::KEY_STEP])) {
            return;
        }
        $model->setStep((float) $data[self::KEY_STEP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedValues(BasicPlusTvVolume $model, array $data): void
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
    private static function applyValue(BasicPlusTvVolume $model, array $data): void
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
    private static function applyVersion(BasicPlusTvVolume $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): BasicPlusTvVolumeCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }

        return $this->basicPlusTvVolumeCommandTransformer->transform($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }

        return $data[self::KEY_COMPONENT];
    }
}
