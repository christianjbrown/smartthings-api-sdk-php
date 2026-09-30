<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Scene implements SceneInterface
{
    private ?string $apiVersion = null;
    private ?string $createdBy = null;
    private ?string $createdDate = null;
    private ?bool $editable = null;
    private ?string $lastExecutedDate = null;
    private ?string $lastUpdatedDate = null;
    private ?string $locationId = null;
    private ?string $sceneColor = null;
    private ?string $sceneIcon = null;
    private string $sceneId;
    private ?string $sceneName = null;

    public function __construct(string $sceneId)
    {
        $this->sceneId = $sceneId;
    }

    public function getApiVersion(): ?string
    {
        return $this->apiVersion;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    public function getEditable(): ?bool
    {
        return $this->editable;
    }

    public function getLastExecutedDate(): ?string
    {
        return $this->lastExecutedDate;
    }

    public function getLastUpdatedDate(): ?string
    {
        return $this->lastUpdatedDate;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getSceneColor(): ?string
    {
        return $this->sceneColor;
    }

    public function getSceneIcon(): ?string
    {
        return $this->sceneIcon;
    }

    public function getSceneId(): string
    {
        return $this->sceneId;
    }

    public function getSceneName(): ?string
    {
        return $this->sceneName;
    }

    public function setApiVersion(?string $value): SceneInterface
    {
        $this->apiVersion = $value;

        return $this;
    }

    public function setCreatedBy(?string $value): SceneInterface
    {
        $this->createdBy = $value;

        return $this;
    }

    public function setCreatedDate(?string $value): SceneInterface
    {
        $this->createdDate = $value;

        return $this;
    }

    public function setEditable(?bool $value): SceneInterface
    {
        $this->editable = $value;

        return $this;
    }

    public function setLastExecutedDate(?string $value): SceneInterface
    {
        $this->lastExecutedDate = $value;

        return $this;
    }

    public function setLastUpdatedDate(?string $value): SceneInterface
    {
        $this->lastUpdatedDate = $value;

        return $this;
    }

    public function setLocationId(?string $value): SceneInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setSceneColor(?string $value): SceneInterface
    {
        $this->sceneColor = $value;

        return $this;
    }

    public function setSceneIcon(?string $value): SceneInterface
    {
        $this->sceneIcon = $value;

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
