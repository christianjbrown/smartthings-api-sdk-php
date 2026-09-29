<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationParent implements LocationParentInterface
{
    private ?string $id = null;
    private ?string $type = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setId(?string $value): LocationParentInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setType(?string $value): LocationParentInterface
    {
        $this->type = $value;

        return $this;
    }
}
