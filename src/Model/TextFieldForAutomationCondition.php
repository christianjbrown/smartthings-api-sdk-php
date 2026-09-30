<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TextFieldForAutomationCondition implements TextFieldForAutomationConditionInterface
{
    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?string $value;
    private ?string $valueType = null;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): TextFieldForAutomationConditionInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setValueType(?string $value): TextFieldForAutomationConditionInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
