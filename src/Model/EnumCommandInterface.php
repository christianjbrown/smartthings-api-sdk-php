<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EnumCommandInterface
{
    public function getCommand(): string;

    public function getValue(): string;
}
