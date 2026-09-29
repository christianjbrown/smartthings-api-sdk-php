<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusTvVolumeCommand implements BasicPlusTvVolumeCommandInterface
{
    private ?string $decrease = null;
    private ?string $increase = null;
    private ?string $name = null;

    public function getDecrease(): ?string
    {
        return $this->decrease;
    }

    public function getIncrease(): ?string
    {
        return $this->increase;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setDecrease(?string $value): BasicPlusTvVolumeCommandInterface
    {
        $this->decrease = $value;

        return $this;
    }

    public function setIncrease(?string $value): BasicPlusTvVolumeCommandInterface
    {
        $this->increase = $value;

        return $this;
    }

    public function setName(?string $value): BasicPlusTvVolumeCommandInterface
    {
        $this->name = $value;

        return $this;
    }
}
