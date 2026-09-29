<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceCategory implements DeviceCategoryInterface
{
    private string $categoryType;
    private string $name;

    public function __construct(string $name, string $categoryType)
    {
        $this->name = $name;
        $this->categoryType = $categoryType;
    }

    public function getCategoryType(): string
    {
        return $this->categoryType;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
