<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityCommandLocalization implements CapabilityCommandLocalizationInterface
{
    /**
     * @var null|array<array-key, CapabilityArgumentLocalizationInterface>
     */
    private ?array $arguments = null;
    private ?string $description = null;
    private ?string $label = null;

    /**
     * @return null|array<array-key, CapabilityArgumentLocalizationInterface>
     */
    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param null|array<array-key, CapabilityArgumentLocalizationInterface> $value
     */
    public function setArguments(?array $value): CapabilityCommandLocalizationInterface
    {
        $this->arguments = $value;

        return $this;
    }

    public function setDescription(?string $value): CapabilityCommandLocalizationInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setLabel(?string $value): CapabilityCommandLocalizationInterface
    {
        $this->label = $value;

        return $this;
    }
}
