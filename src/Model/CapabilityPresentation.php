<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityPresentation implements CapabilityPresentationInterface
{
    private string $id;
    private ?int $version = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setId(string $value): CapabilityPresentationInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setVersion(?int $value): CapabilityPresentationInterface
    {
        $this->version = $value;

        return $this;
    }
}
