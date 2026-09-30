<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneInterface
{
    public function getApiVersion(): ?string;

    public function getCreatedBy(): ?string;

    public function getCreatedDate(): ?string;

    public function getEditable(): ?bool;

    public function getLastExecutedDate(): ?string;

    public function getLastUpdatedDate(): ?string;

    public function getLocationId(): ?string;

    public function getSceneColor(): ?string;

    public function getSceneIcon(): ?string;

    public function getSceneId(): string;

    public function getSceneName(): ?string;

    public function setApiVersion(?string $value): self;

    public function setCreatedBy(?string $value): self;

    public function setCreatedDate(?string $value): self;

    public function setEditable(?bool $value): self;

    public function setLastExecutedDate(?string $value): self;

    public function setLastUpdatedDate(?string $value): self;

    public function setLocationId(?string $value): self;

    public function setSceneColor(?string $value): self;

    public function setSceneIcon(?string $value): self;

    public function setSceneId(string $value): self;

    public function setSceneName(?string $value): self;
}
