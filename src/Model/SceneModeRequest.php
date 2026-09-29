<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneModeRequest implements SceneModeRequestInterface
{
    private ?string $actionId = null;
    private string $modeId;
    private ?string $modeName = null;

    public function __construct(string $modeId)
    {
        $this->modeId = $modeId;
    }

    public function getActionId(): ?string
    {
        return $this->actionId;
    }

    public function getModeId(): string
    {
        return $this->modeId;
    }

    public function getModeName(): ?string
    {
        return $this->modeName;
    }

    public function setActionId(?string $value): SceneModeRequestInterface
    {
        $this->actionId = $value;

        return $this;
    }

    public function setModeName(?string $value): SceneModeRequestInterface
    {
        $this->modeName = $value;

        return $this;
    }
}
