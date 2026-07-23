<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Localization implements LocalizationInterface
{
    private ?string $description = null;
    private ?string $label = null;
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function setDescription(?string $value): LocalizationInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setLabel(?string $value): LocalizationInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setTag(string $value): LocalizationInterface
    {
        $this->tag = $value;

        return $this;
    }
}
