<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SupportedValuesForDynamicListInterface
{
    public function getValue(): ?string;

    public function getValueMap(): ?SupportedValuesForDynamicListValueMapInterface;

    public function setValueMap(?SupportedValuesForDynamicListValueMapInterface $value): self;
}
