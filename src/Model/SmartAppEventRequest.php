<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SmartAppEventRequest implements SmartAppEventRequestInterface
{
    /**
     * @var null|array<string, string>
     */
    private ?array $attributes = null;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return null|array<string, string>
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param null|array<string, string> $value
     */
    public function setAttributes(?array $value): SmartAppEventRequestInterface
    {
        $this->attributes = $value;

        return $this;
    }
}
