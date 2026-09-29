<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListForAutomationAction implements ListForAutomationActionInterface
{
    /**
     * @var array<int, AlternativeItemInterface>
     */
    private array $alternatives;
    private ?string $argumentType = null;
    private ?string $command = null;
    private ?string $supportedValues = null;

    /**
     * @phpstan-param array<int, AlternativeItemInterface> $alternatives
     */
    public function __construct(array $alternatives)
    {
        $this->alternatives = $alternatives;
    }

    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array
    {
        return $this->alternatives;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function setArgumentType(?string $value): ListForAutomationActionInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setCommand(?string $value): ListForAutomationActionInterface
    {
        $this->command = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): ListForAutomationActionInterface
    {
        $this->supportedValues = $value;

        return $this;
    }
}
