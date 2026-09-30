<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SleepActionExecutionResult implements SleepActionExecutionResultInterface
{
    private ?string $result = null;

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $value): SleepActionExecutionResultInterface
    {
        $this->result = $value;

        return $this;
    }
}
