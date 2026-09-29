<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DriverPermission implements DriverPermissionInterface
{
    /**
     * @var mixed[]
     */
    private array $attributes;
    private string $name;

    /**
     * @phpstan-param mixed[] $attributes
     */
    public function __construct(string $name, array $attributes)
    {
        $this->name = $name;
        $this->attributes = $attributes;
    }

    /**
     * @return mixed[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
