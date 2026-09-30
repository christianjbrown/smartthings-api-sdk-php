<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SceneConfigInterface;

interface SceneConfigTransformerInterface
{
    public const string KEY_PERMISSIONS = 'permissions';
    public const string KEY_SCENE_ID = 'sceneId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SceneConfigInterface;
}
