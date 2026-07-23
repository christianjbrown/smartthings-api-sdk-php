<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DevicePreferenceDefinition implements DevicePreferenceDefinitionInterface
{
    private ?string $description = null;
    private ?string $name = null;
    private string $preferenceId;
    private ?string $preferenceType = null;
    private ?bool $required = null;
    private ?string $title = null;

    public function __construct(string $preferenceId)
    {
        $this->preferenceId = $preferenceId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPreferenceId(): string
    {
        return $this->preferenceId;
    }

    public function getPreferenceType(): ?string
    {
        return $this->preferenceType;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(?string $value): DevicePreferenceDefinitionInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setName(?string $value): DevicePreferenceDefinitionInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setPreferenceId(string $value): DevicePreferenceDefinitionInterface
    {
        $this->preferenceId = $value;

        return $this;
    }

    public function setPreferenceType(?string $value): DevicePreferenceDefinitionInterface
    {
        $this->preferenceType = $value;

        return $this;
    }

    public function setRequired(?bool $value): DevicePreferenceDefinitionInterface
    {
        $this->required = $value;

        return $this;
    }

    public function setTitle(?string $value): DevicePreferenceDefinitionInterface
    {
        $this->title = $value;

        return $this;
    }
}
