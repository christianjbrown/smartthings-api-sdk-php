<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SceneExecutionResultInterface;

interface SceneExecutionResultTransformerInterface
{
    public const string KEY_STATUS = 'status';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SceneExecutionResultInterface;
}
