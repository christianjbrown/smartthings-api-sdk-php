<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneCommand implements SceneCommandInterface
{
    /**
     * @var null|array<int, SceneArgumentInterface>
     */
    private ?array $arguments = null;

    /**
     * @return null|array<int, SceneArgumentInterface>
     */
    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    /**
     * @param null|array<int, SceneArgumentInterface> $value
     */
    public function setArguments(?array $value): SceneCommandInterface
    {
        $this->arguments = $value;

        return $this;
    }
}
