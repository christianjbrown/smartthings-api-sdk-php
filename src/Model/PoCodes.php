<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PoCodes implements PoCodesInterface
{
    private ?string $label;
    private ?string $po;

    public function __construct(?string $label, ?string $po)
    {
        $this->label = $label;
        $this->po = $po;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getPo(): ?string
    {
        return $this->po;
    }
}
