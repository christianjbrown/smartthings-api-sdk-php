<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityAttributeLocalization implements CapabilityAttributeLocalizationInterface
{
    private ?string $description = null;
    private ?string $displayTemplate = null;

    /**
     * @var null|array<array-key, array<array-key, CapabilityAttributeLabelInterface>>
     */
    private ?array $i18n = null;
    private ?string $label = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDisplayTemplate(): ?string
    {
        return $this->displayTemplate;
    }

    /**
     * @return null|array<array-key, array<array-key, CapabilityAttributeLabelInterface>>
     */
    public function getI18n(): ?array
    {
        return $this->i18n;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setDescription(?string $value): CapabilityAttributeLocalizationInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDisplayTemplate(?string $value): CapabilityAttributeLocalizationInterface
    {
        $this->displayTemplate = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, array<array-key, CapabilityAttributeLabelInterface>> $value
     */
    public function setI18n(?array $value): CapabilityAttributeLocalizationInterface
    {
        $this->i18n = $value;

        return $this;
    }

    public function setLabel(?string $value): CapabilityAttributeLocalizationInterface
    {
        $this->label = $value;

        return $this;
    }
}
