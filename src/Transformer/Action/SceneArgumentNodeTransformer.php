<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneArgument;
use ChristianBrown\SmartThings\Model\SceneArgumentInterface;

use function is_array;
use function is_string;

/**
 * Builds SceneArgumentInterface from its decoded JSON.
 */
final class SceneArgumentNodeTransformer implements SceneArgumentNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneArgumentInterface
    {
        $model = new SceneArgument();

        self::applyName($model, $data);
        self::applySchema($model, $data);
        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(SceneArgument $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySchema(SceneArgument $model, array $data): void
    {
        if (!isset($data[self::KEY_SCHEMA])) {
            return;
        }
        if (!is_array($data[self::KEY_SCHEMA])) {
            return;
        }
        $model->setSchema($data[self::KEY_SCHEMA]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(SceneArgument $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }
}
