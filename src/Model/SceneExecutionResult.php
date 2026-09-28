<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneExecutionResult implements SceneExecutionResultInterface
{
    private ?string $status = null;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $value): SceneExecutionResultInterface
    {
        $this->status = $value;

        return $this;
    }
}
