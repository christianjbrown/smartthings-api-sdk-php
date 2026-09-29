<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceProfileReference implements DeviceProfileReferenceInterface
{
    private ?string $id = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $value): DeviceProfileReferenceInterface
    {
        $this->id = $value;

        return $this;
    }
}
