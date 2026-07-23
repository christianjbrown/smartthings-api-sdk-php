<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Capability implements CapabilityInterface
{
    private string $id;
    private ?string $name = null;
    private ?string $status = null;
    private ?int $version = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setId(string $value): CapabilityInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setName(?string $value): CapabilityInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setStatus(?string $value): CapabilityInterface
    {
        $this->status = $value;

        return $this;
    }

    public function setVersion(?int $value): CapabilityInterface
    {
        $this->version = $value;

        return $this;
    }
}
