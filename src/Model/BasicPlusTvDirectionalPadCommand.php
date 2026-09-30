<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusTvDirectionalPadCommand implements BasicPlusTvDirectionalPadCommandInterface
{
    private ?string $down;
    private ?string $left;
    private ?string $name = null;
    private ?string $ok;
    private ?string $right;
    private ?string $up;

    public function __construct(?string $up, ?string $down, ?string $left, ?string $right, ?string $ok)
    {
        $this->up = $up;
        $this->down = $down;
        $this->left = $left;
        $this->right = $right;
        $this->ok = $ok;
    }

    public function getDown(): ?string
    {
        return $this->down;
    }

    public function getLeft(): ?string
    {
        return $this->left;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOk(): ?string
    {
        return $this->ok;
    }

    public function getRight(): ?string
    {
        return $this->right;
    }

    public function getUp(): ?string
    {
        return $this->up;
    }

    public function setName(?string $value): BasicPlusTvDirectionalPadCommandInterface
    {
        $this->name = $value;

        return $this;
    }
}
