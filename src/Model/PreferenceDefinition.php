<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PreferenceDefinition implements PreferenceDefinitionInterface
{
    private mixed $defaultValue = null;
    private ?float $maximum = null;
    private ?int $maxLength = null;
    private ?float $minimum = null;
    private ?int $minLength = null;

    /**
     * @var null|array<array-key, string>
     */
    private ?array $options = null;
    private ?string $stringType = null;

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function getMaximum(): ?float
    {
        return $this->maximum;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    public function getMinimum(): ?float
    {
        return $this->minimum;
    }

    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    /**
     * @return null|array<array-key, string>
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function getStringType(): ?string
    {
        return $this->stringType;
    }

    public function setDefaultValue(mixed $value): PreferenceDefinitionInterface
    {
        $this->defaultValue = $value;

        return $this;
    }

    public function setMaximum(?float $value): PreferenceDefinitionInterface
    {
        $this->maximum = $value;

        return $this;
    }

    public function setMaxLength(?int $value): PreferenceDefinitionInterface
    {
        $this->maxLength = $value;

        return $this;
    }

    public function setMinimum(?float $value): PreferenceDefinitionInterface
    {
        $this->minimum = $value;

        return $this;
    }

    public function setMinLength(?int $value): PreferenceDefinitionInterface
    {
        $this->minLength = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, string> $value
     */
    public function setOptions(?array $value): PreferenceDefinitionInterface
    {
        $this->options = $value;

        return $this;
    }

    public function setStringType(?string $value): PreferenceDefinitionInterface
    {
        $this->stringType = $value;

        return $this;
    }
}
