<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MultiArgCommandArgumentsItemInterface
{
    public function getDisplayType(): string;

    public function getLabel(): string;

    public function getList(): ?ListForArgumentInterface;

    public function getNumberField(): ?NumberFieldForArgumentInterface;

    public function getSlider(): ?SliderForArgumentInterface;

    public function getTextField(): ?TextFieldForArgumentInterface;

    public function setList(?ListForArgumentInterface $value): self;

    public function setNumberField(?NumberFieldForArgumentInterface $value): self;

    public function setSlider(?SliderForArgumentInterface $value): self;

    public function setTextField(?TextFieldForArgumentInterface $value): self;
}
