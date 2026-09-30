<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneSleepRequest implements SceneSleepRequestInterface
{
    private ?int $seconds;

    public function __construct(?int $seconds)
    {
        $this->seconds = $seconds;
    }

    public function getSeconds(): ?int
    {
        return $this->seconds;
    }
}
