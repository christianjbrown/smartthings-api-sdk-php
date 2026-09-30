<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ModeConfig implements ModeConfigInterface
{
    private ?string $modeId = null;

    public function getModeId(): ?string
    {
        return $this->modeId;
    }

    public function setModeId(?string $value): ModeConfigInterface
    {
        $this->modeId = $value;

        return $this;
    }
}
