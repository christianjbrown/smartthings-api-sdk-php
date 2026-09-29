<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DynamicListForAutomationAction implements DynamicListForAutomationActionInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $argumentType = null;
    private ?string $command = null;
    private SupportedValuesForDynamicListInterface $supportedValues;

    public function __construct(SupportedValuesForDynamicListInterface $supportedValues)
    {
        $this->supportedValues = $supportedValues;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
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

    public function getSupportedValues(): SupportedValuesForDynamicListInterface
    {
        return $this->supportedValues;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): DynamicListForAutomationActionInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setArgumentType(?string $value): DynamicListForAutomationActionInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setCommand(?string $value): DynamicListForAutomationActionInterface
    {
        $this->command = $value;

        return $this;
    }
}
