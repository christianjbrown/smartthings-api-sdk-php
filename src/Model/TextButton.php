<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TextButton implements TextButtonInterface
{
    /**
     * @var array<int, TextButtonButtonsItemInterface>
     */
    private array $buttons;
    private ?string $command = null;
    private ?string $supportedValues = null;
    private ?string $value = null;

    /**
     * @phpstan-param array<int, TextButtonButtonsItemInterface> $buttons
     */
    public function __construct(array $buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * @return array<int, TextButtonButtonsItemInterface>
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setCommand(?string $value): TextButtonInterface
    {
        $this->command = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): TextButtonInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setValue(?string $value): TextButtonInterface
    {
        $this->value = $value;

        return $this;
    }
}
