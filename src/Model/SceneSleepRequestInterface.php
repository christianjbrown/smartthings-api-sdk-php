<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneSleepRequestInterface
{
    public function getSeconds(): int;
}
