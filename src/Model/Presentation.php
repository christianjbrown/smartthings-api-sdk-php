<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Presentation implements PresentationInterface
{
    private ?string $manufacturerName = null;
    private string $presentationId;
    private ?string $type = null;

    public function __construct(string $presentationId)
    {
        $this->presentationId = $presentationId;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function getPresentationId(): string
    {
        return $this->presentationId;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setManufacturerName(?string $value): PresentationInterface
    {
        $this->manufacturerName = $value;

        return $this;
    }

    public function setPresentationId(string $value): PresentationInterface
    {
        $this->presentationId = $value;

        return $this;
    }

    public function setType(?string $value): PresentationInterface
    {
        $this->type = $value;

        return $this;
    }
}
