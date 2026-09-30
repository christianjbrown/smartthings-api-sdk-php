<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TextButtonButtonsItem implements TextButtonButtonsItemInterface
{
    private ?string $key;
    private ?string $label;
    private ?string $state = null;

    public function __construct(?string $key, ?string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $value): TextButtonButtonsItemInterface
    {
        $this->state = $value;

        return $this;
    }
}
