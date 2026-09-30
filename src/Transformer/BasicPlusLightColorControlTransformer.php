<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControl;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColorInterface;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlInterface;

use function is_array;
use function is_int;
use function is_string;

final class BasicPlusLightColorControlTransformer implements BasicPlusLightColorControlTransformerInterface
{
    private BasicPlusLightColorControlColorTransformerInterface $basicPlusLightColorControlColorTransformer;

    public function __construct(BasicPlusLightColorControlColorTransformerInterface $basicPlusLightColorControlColorTransformer)
    {
        $this->basicPlusLightColorControlColorTransformer = $basicPlusLightColorControlColorTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusLightColorControlInterface
    {
        $model = new BasicPlusLightColorControl(self::requireComponent($data), self::requireCapability($data), self::requireCommand($data), $this->requireColor($data));

        self::applyVersion($model, $data);
        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(BasicPlusLightColorControl $model, array $data): void
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
    private static function applyVersion(BasicPlusLightColorControl $model, array $data): void
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
    private function requireColor(array $data): ?BasicPlusLightColorControlColorInterface
    {
        if (!isset($data[self::KEY_COLOR])) {
            return null;
        }
        if (!is_array($data[self::KEY_COLOR])) {
            return null;
        }

        return $this->basicPlusLightColorControlColorTransformer->transform($data[self::KEY_COLOR]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCommand(array $data): ?string
    {
        if (empty($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return null;
        }

        return $data[self::KEY_COMMAND];
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
