<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Scene implements SceneInterface
{
    private ?string $locationId = null;
    private string $sceneId;
    private ?string $sceneName = null;

    public function __construct(string $sceneId)
    {
        $this->sceneId = $sceneId;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getSceneId(): string
    {
        return $this->sceneId;
    }

    public function getSceneName(): ?string
    {
        return $this->sceneName;
    }

    public function setLocationId(?string $value): SceneInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setSceneId(string $value): SceneInterface
    {
        $this->sceneId = $value;

        return $this;
    }

    public function setSceneName(?string $value): SceneInterface
    {
        $this->sceneName = $value;

        return $this;
    }
}
