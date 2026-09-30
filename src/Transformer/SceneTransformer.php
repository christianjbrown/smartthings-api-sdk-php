<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Scene;
use ChristianBrown\SmartThings\Model\SceneInterface;

use function is_string;
use function sprintf;

final class SceneTransformer implements SceneTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SceneInterface
    {
        if (empty($data[self::KEY_SCENE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_SCENE_ID));
        }
        if (!is_string($data[self::KEY_SCENE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_SCENE_ID));
        }
        $scene = new Scene($data[self::KEY_SCENE_ID]);

        self::applyLocationId($scene, $data);
        self::applySceneName($scene, $data);
        $this->applyDetails($scene, $data);

        return $scene;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(SceneInterface $scene, array $data): void
    {
        $scene->setSceneIcon($this->valueReader->string($data, self::KEY_SCENE_ICON));
        $scene->setSceneColor($this->valueReader->string($data, self::KEY_SCENE_COLOR));
        $scene->setCreatedBy($this->valueReader->string($data, self::KEY_CREATED_BY));
        $scene->setCreatedDate($this->valueReader->string($data, self::KEY_CREATED_DATE));
        $scene->setLastUpdatedDate($this->valueReader->string($data, self::KEY_LAST_UPDATED_DATE));
        $scene->setLastExecutedDate($this->valueReader->string($data, self::KEY_LAST_EXECUTED_DATE));
        $scene->setEditable($this->valueReader->bool($data, self::KEY_EDITABLE));
        $scene->setApiVersion($this->valueReader->string($data, self::KEY_API_VERSION));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(Scene $scene, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $scene->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneName(Scene $scene, array $data): void
    {
        if (empty($data[self::KEY_SCENE_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_SCENE_NAME])) {
            return;
        }
        $scene->setSceneName($data[self::KEY_SCENE_NAME]);
    }
}
