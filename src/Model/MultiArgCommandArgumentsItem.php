<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MultiArgCommandArgumentsItem implements MultiArgCommandArgumentsItemInterface
{
    private ?string $displayType;
    private ?string $label;
    private ?ListForArgumentInterface $list = null;
    private ?NumberFieldForArgumentInterface $numberField = null;
    private ?SliderForArgumentInterface $slider = null;
    private ?TextFieldForArgumentInterface $textField = null;

    public function __construct(?string $label, ?string $displayType)
    {
        $this->label = $label;
        $this->displayType = $displayType;
    }

    public function getDisplayType(): ?string
    {
        return $this->displayType;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getList(): ?ListForArgumentInterface
    {
        return $this->list;
    }

    public function getNumberField(): ?NumberFieldForArgumentInterface
    {
        return $this->numberField;
    }

    public function getSlider(): ?SliderForArgumentInterface
    {
        return $this->slider;
    }

    public function getTextField(): ?TextFieldForArgumentInterface
    {
        return $this->textField;
    }

    public function setList(?ListForArgumentInterface $value): MultiArgCommandArgumentsItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setNumberField(?NumberFieldForArgumentInterface $value): MultiArgCommandArgumentsItemInterface
    {
        $this->numberField = $value;

        return $this;
    }

    public function setSlider(?SliderForArgumentInterface $value): MultiArgCommandArgumentsItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setTextField(?TextFieldForArgumentInterface $value): MultiArgCommandArgumentsItemInterface
    {
        $this->textField = $value;

        return $this;
    }
}
