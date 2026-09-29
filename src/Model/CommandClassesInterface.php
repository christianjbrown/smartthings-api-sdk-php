<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CommandClassesInterface
{
    /**
     * @return null|array<int, int>
     */
    public function getControlled(): ?array;

    /**
     * @return null|array<int, int>
     */
    public function getEither(): ?array;

    /**
     * @return null|array<int, int>
     */
    public function getSupported(): ?array;

    /**
     * @param null|array<int, int> $value
     */
    public function setControlled(?array $value): self;

    /**
     * @param null|array<int, int> $value
     */
    public function setEither(?array $value): self;

    /**
     * @param null|array<int, int> $value
     */
    public function setSupported(?array $value): self;
}
