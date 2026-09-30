<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BehaviorAbnormalExecutionResult implements BehaviorAbnormalExecutionResultInterface
{
    private ?string $reason = null;
    private ?string $result = null;

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setReason(?string $value): BehaviorAbnormalExecutionResultInterface
    {
        $this->reason = $value;

        return $this;
    }

    public function setResult(?string $value): BehaviorAbnormalExecutionResultInterface
    {
        $this->result = $value;

        return $this;
    }
}
