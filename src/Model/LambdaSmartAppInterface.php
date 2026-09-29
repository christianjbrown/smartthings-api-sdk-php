<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LambdaSmartAppInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getFunctions(): ?array;

    /**
     * @param null|array<int, string> $value
     */
    public function setFunctions(?array $value): self;
}
