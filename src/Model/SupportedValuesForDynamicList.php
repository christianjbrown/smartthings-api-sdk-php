<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SupportedValuesForDynamicList implements SupportedValuesForDynamicListInterface
{
    private ?string $value;
    private ?SupportedValuesForDynamicListValueMapInterface $valueMap = null;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueMap(): ?SupportedValuesForDynamicListValueMapInterface
    {
        return $this->valueMap;
    }

    public function setValueMap(?SupportedValuesForDynamicListValueMapInterface $value): SupportedValuesForDynamicListInterface
    {
        $this->valueMap = $value;

        return $this;
    }
}
