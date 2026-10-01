<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneModeRequest;
use ChristianBrown\SmartThings\Model\SceneModeRequestInterface;

use function is_string;

/**
 * Builds SceneModeRequestInterface from its decoded JSON.
 */
final class SceneModeRequestNodeTransformer implements SceneModeRequestNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneModeRequestInterface
    {
        $model = new SceneModeRequest(self::requireModeId($data));

        self::applyActionId($model, $data);
        self::applyModeName($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionId(SceneModeRequest $model, array $data): void
    {
        if (empty($data[self::KEY_ACTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTION_ID])) {
            return;
        }
        $model->setActionId($data[self::KEY_ACTION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModeName(SceneModeRequest $model, array $data): void
    {
        if (empty($data[self::KEY_MODE_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MODE_NAME])) {
            return;
        }
        $model->setModeName($data[self::KEY_MODE_NAME]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireModeId(array $data): ?string
    {
        if (empty($data[self::KEY_MODE_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_MODE_ID])) {
            return null;
        }

        return $data[self::KEY_MODE_ID];
    }
}
