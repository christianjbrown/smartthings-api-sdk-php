<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DriverPermissionInterface
{
    /**
     * @return mixed[]
     */
    public function getAttributes(): array;

    public function getName(): string;
}
