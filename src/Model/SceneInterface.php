<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneInterface
{
    public function getLocationId(): ?string;

    public function getSceneId(): string;

    public function getSceneName(): ?string;

    public function setLocationId(?string $value): self;

    public function setSceneId(string $value): self;

    public function setSceneName(?string $value): self;
}
