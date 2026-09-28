<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SceneExecutionResult;
use ChristianBrown\SmartThings\Model\SceneExecutionResultInterface;

use function is_string;

final class SceneExecutionResultTransformer implements SceneExecutionResultTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SceneExecutionResultInterface
    {
        $result = new SceneExecutionResult();

        self::applyStatus($result, $data);

        return $result;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatus(SceneExecutionResult $result, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $result->setStatus($data[self::KEY_STATUS]);
    }
}
