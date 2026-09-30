<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneModeRequestInterface
{
    public function getActionId(): ?string;

    public function getModeId(): ?string;

    public function getModeName(): ?string;

    public function setActionId(?string $value): self;

    public function setModeName(?string $value): self;
}
