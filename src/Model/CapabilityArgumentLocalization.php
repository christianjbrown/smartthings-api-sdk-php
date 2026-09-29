<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityArgumentLocalization implements CapabilityArgumentLocalizationInterface
{
    private ?string $description = null;

    /**
     * @var null|array<array-key, CapabilityArgumentI18nInterface>
     */
    private ?array $i18n = null;
    private ?string $label = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return null|array<array-key, CapabilityArgumentI18nInterface>
     */
    public function getI18n(): ?array
    {
        return $this->i18n;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setDescription(?string $value): CapabilityArgumentLocalizationInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, CapabilityArgumentI18nInterface> $value
     */
    public function setI18n(?array $value): CapabilityArgumentLocalizationInterface
    {
        $this->i18n = $value;

        return $this;
    }

    public function setLabel(?string $value): CapabilityArgumentLocalizationInterface
    {
        $this->label = $value;

        return $this;
    }
}
