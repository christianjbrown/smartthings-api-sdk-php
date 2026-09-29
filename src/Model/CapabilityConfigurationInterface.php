<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityConfigurationInterface
{
    /**
     * @return array<int, CapabilityConfigurationValueInterface>
     */
    public function getValues(): array;
}
