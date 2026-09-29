<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AlternativeItem implements AlternativeItemInterface
{
    private ?string $description = null;
    private ?string $iconUrl = null;
    private string $key;
    private ?string $type = null;
    private string $value;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setDescription(?string $value): AlternativeItemInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setIconUrl(?string $value): AlternativeItemInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    public function setType(?string $value): AlternativeItemInterface
    {
        $this->type = $value;

        return $this;
    }
}
