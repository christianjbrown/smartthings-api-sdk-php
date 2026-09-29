<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateDeviceComponent implements UpdateDeviceComponentInterface
{
    /**
     * @var array<int, string>
     */
    private array $categories;
    private ?string $icon = null;
    private string $id;
    private ?string $label = null;

    /**
     * @phpstan-param array<int, string> $categories
     */
    public function __construct(string $id, array $categories)
    {
        $this->id = $id;
        $this->categories = $categories;
    }

    /**
     * @return array<int, string>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setIcon(?string $value): UpdateDeviceComponentInterface
    {
        $this->icon = $value;

        return $this;
    }

    public function setLabel(?string $value): UpdateDeviceComponentInterface
    {
        $this->label = $value;

        return $this;
    }
}
