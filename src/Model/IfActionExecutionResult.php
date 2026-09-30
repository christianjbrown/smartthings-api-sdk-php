<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IfActionExecutionResult implements IfActionExecutionResultInterface
{
    private ?string $result = null;

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $value): IfActionExecutionResultInterface
    {
        $this->result = $value;

        return $this;
    }
}
