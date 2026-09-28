<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PreferenceRequest implements PreferenceRequestInterface
{
    /**
     * @var mixed[]
     */
    private array $definition;
    private ?string $description = null;
    private ?bool $explicit = null;
    private string $name;
    private ?string $preferenceId = null;
    private string $preferenceType;
    private ?bool $required = null;
    private string $title;

    /**
     * @phpstan-param mixed[] $definition
     */
    public function __construct(string $name, string $title, string $preferenceType, array $definition)
    {
        $this->name = $name;
        $this->title = $title;
        $this->preferenceType = $preferenceType;
        $this->definition = $definition;
    }

    /**
     * @return mixed[]
     */
    public function getDefinition(): array
    {
        return $this->definition;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getExplicit(): ?bool
    {
        return $this->explicit;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPreferenceId(): ?string
    {
        return $this->preferenceId;
    }

    public function getPreferenceType(): string
    {
        return $this->preferenceType;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(?string $value): PreferenceRequestInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setExplicit(?bool $value): PreferenceRequestInterface
    {
        $this->explicit = $value;

        return $this;
    }

    public function setPreferenceId(?string $value): PreferenceRequestInterface
    {
        $this->preferenceId = $value;

        return $this;
    }

    public function setRequired(?bool $value): PreferenceRequestInterface
    {
        $this->required = $value;

        return $this;
    }
}
