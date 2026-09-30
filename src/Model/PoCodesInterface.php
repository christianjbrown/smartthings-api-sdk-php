<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PoCodesInterface
{
    public function getLabel(): ?string;

    public function getPo(): ?string;
}
