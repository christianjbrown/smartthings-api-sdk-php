<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EnumCommand implements EnumCommandInterface
{
    private ?string $command;
    private ?string $value;

    public function __construct(?string $command, ?string $value)
    {
        $this->command = $command;
        $this->value = $value;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
