<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SupportedValuesForDynamicListValueMapInterface
{
    public function getKey(): string;

    public function getValue(): string;
}
