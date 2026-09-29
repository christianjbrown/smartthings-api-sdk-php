<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MultiArgCommand implements MultiArgCommandInterface
{
    /**
     * @var array<int, MultiArgCommandArgumentsItemInterface>
     */
    private array $arguments;
    private string $command;
    private ?string $supportedValues = null;

    /**
     * @phpstan-param array<int, MultiArgCommandArgumentsItemInterface> $arguments
     */
    public function __construct(string $command, array $arguments)
    {
        $this->command = $command;
        $this->arguments = $arguments;
    }

    /**
     * @return array<int, MultiArgCommandArgumentsItemInterface>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function setSupportedValues(?string $value): MultiArgCommandInterface
    {
        $this->supportedValues = $value;

        return $this;
    }
}
