<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneConfigInterface
{
    /**
     * @return array<int, string>
     */
    public function getPermissions(): array;

    public function getSceneId(): ?string;

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): self;

    public function setSceneId(?string $value): self;
}
