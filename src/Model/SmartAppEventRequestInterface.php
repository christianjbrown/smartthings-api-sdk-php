<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SmartAppEventRequestInterface
{
    /**
     * @return null|array<string, string>
     */
    public function getAttributes(): ?array;

    public function getName(): string;

    /**
     * @param null|array<string, string> $value
     */
    public function setAttributes(?array $value): self;
}
