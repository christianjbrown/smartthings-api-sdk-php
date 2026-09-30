<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TextFieldForAutomationConditionInterface
{
    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setValueType(?string $value): self;
}
