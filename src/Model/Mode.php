<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Mode implements ModeInterface
{
    private string $id;
    private ?string $label = null;
    private ?string $name = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setId(string $value): ModeInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setLabel(?string $value): ModeInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setName(?string $value): ModeInterface
    {
        $this->name = $value;

        return $this;
    }
}
