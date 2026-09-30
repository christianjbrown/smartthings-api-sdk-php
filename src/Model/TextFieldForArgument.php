<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TextFieldForArgument implements TextFieldForArgumentInterface
{
    private ?string $argumentType = null;
    private ?string $name;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;

    public function __construct(?string $name)
    {
        $this->name = $name;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
    }

    public function setArgumentType(?string $value): TextFieldForArgumentInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): TextFieldForArgumentInterface
    {
        $this->range = $value;

        return $this;
    }
}
