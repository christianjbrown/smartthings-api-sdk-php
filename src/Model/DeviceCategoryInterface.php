<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceCategoryInterface
{
    public function getCategoryType(): string;

    public function getName(): string;
}
