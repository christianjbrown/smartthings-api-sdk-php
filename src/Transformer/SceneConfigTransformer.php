<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SceneConfig;
use ChristianBrown\SmartThings\Model\SceneConfigInterface;

final class SceneConfigTransformer implements SceneConfigTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SceneConfigInterface
    {
        return (new SceneConfig())
            ->setSceneId($this->valueReader->string($data, self::KEY_SCENE_ID))
            ->setPermissions($this->valueReader->strings($data, self::KEY_PERMISSIONS));
    }
}
