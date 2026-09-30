<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvChannel;
use ChristianBrown\SmartThings\Model\BasicPlusTvChannelInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;

use function is_array;
use function is_int;
use function is_string;

final class BasicPlusTvChannelTransformer implements BasicPlusTvChannelTransformerInterface
{
    private BasicPlusTvVolumeCommandTransformerInterface $basicPlusTvVolumeCommandTransformer;

    public function __construct(BasicPlusTvVolumeCommandTransformerInterface $basicPlusTvVolumeCommandTransformer)
    {
        $this->basicPlusTvVolumeCommandTransformer = $basicPlusTvVolumeCommandTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvChannelInterface
    {
        $model = new BasicPlusTvChannel(self::requireCapability($data), self::requireComponent($data), $this->requireCommand($data));

        self::applyVersion($model, $data);
        self::applyLabel($model, $data);
        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(BasicPlusTvChannel $model, array $data): void
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
    private static function applyValue(BasicPlusTvChannel $model, array $data): void
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
    private static function applyVersion(BasicPlusTvChannel $model, array $data): void
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
    private static function requireCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): ?BasicPlusTvVolumeCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            return null;
        }

        return $this->basicPlusTvVolumeCommandTransformer->transform($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
    }
}
