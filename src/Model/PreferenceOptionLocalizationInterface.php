<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PreferenceOptionLocalizationInterface
{
    public function getLabel(): string;
}
