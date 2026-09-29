<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneCommandInterface
{
    /**
     * @return null|array<int, SceneArgumentInterface>
     */
    public function getArguments(): ?array;

    /**
     * @param null|array<int, SceneArgumentInterface> $value
     */
    public function setArguments(?array $value): self;
}
