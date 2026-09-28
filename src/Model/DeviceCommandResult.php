<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceCommandResult implements DeviceCommandResultInterface
{
    private ?string $id = null;
    private ?string $status = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setId(?string $value): DeviceCommandResultInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setStatus(?string $value): DeviceCommandResultInterface
    {
        $this->status = $value;

        return $this;
    }
}
