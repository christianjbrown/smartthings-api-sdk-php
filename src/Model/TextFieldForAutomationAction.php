<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TextFieldForAutomationAction implements TextFieldForAutomationActionInterface
{
    private ?string $argumentType = null;
    private string $command;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
    }

    public function setArgumentType(?string $value): TextFieldForAutomationActionInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): TextFieldForAutomationActionInterface
    {
        $this->range = $value;

        return $this;
    }
}
