<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PreferenceLocalizationRequest implements PreferenceLocalizationRequestInterface
{
    private ?string $description = null;
    private string $label;

    /**
     * @var null|array<array-key, PreferenceOptionLocalizationInterface>
     */
    private ?array $options = null;
    private string $tag;

    public function __construct(string $tag, string $label)
    {
        $this->tag = $tag;
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

    /**
     * @return null|array<array-key, PreferenceOptionLocalizationInterface>
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function setDescription(?string $value): PreferenceLocalizationRequestInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, PreferenceOptionLocalizationInterface> $value
     */
    public function setOptions(?array $value): PreferenceLocalizationRequestInterface
    {
        $this->options = $value;

        return $this;
    }
}
