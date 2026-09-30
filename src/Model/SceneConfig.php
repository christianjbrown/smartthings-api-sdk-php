<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneConfig implements SceneConfigInterface
{
    /**
     * @var array<int, string>
     */
    private array $permissions = [];
    private ?string $sceneId = null;

    /**
     * @return array<int, string>
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getSceneId(): ?string
    {
        return $this->sceneId;
    }

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): SceneConfigInterface
    {
        $this->permissions = $value;

        return $this;
    }

    public function setSceneId(?string $value): SceneConfigInterface
    {
        $this->sceneId = $value;

        return $this;
    }
}
