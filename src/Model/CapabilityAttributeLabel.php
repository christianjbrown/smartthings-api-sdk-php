<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityAttributeLabel implements CapabilityAttributeLabelInterface
{
    private ?string $description = null;
    private string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setDescription(?string $value): CapabilityAttributeLabelInterface
    {
        $this->description = $value;

        return $this;
    }
}
